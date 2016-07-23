/*
 * Author:	Abhishek Acharya
 * Board:	CC3200_launchpad
 * Date:	25-06-16
 */

									/*************BASIC DESCRIPTION************/
/*
 * red_led					GPIO9			PIN_64
 * green_led				GPI11			PIN_02
 * yellow_led				GPI10			PIN_01
 */


                                    /*******INCLUDES AND GLOBLE VARIABLES*******/

#define pi 3.14159265358979323846

#include  <stdlib.h>
#include "commonheader.h"
#include "Energia.h"
#ifndef __CC3200R1M1RGC__
// Do not include SPI for CC3200 LaunchPad
#include <SPI.h>
#endif
#include <WiFi.h>
extern void (* const g_pfnVectors[])(void); //declaration of the Interrupt vector table {extern because it has been already declared in startup_ccs.c}
uint32_t sec,task_flag,PowerIN_flag=1,connected_flag1,connected_flag2,phase_flag1,phase_flag2,server_flag=1;        // Variable used by every task

// variables used for frequency and phase calculation
uint32_t time1,time2,time3;
volatile float volt_sample[500];
volatile uint16_t queue1_length,queue_length1;
float frequency,rms_volt=0,rms_v[70],rms_v_avg;
char voltage[10],freq[10];

// variables used for current1 and phase1 calculation
uint32_t time4,time5,time6;
float phase1,power_factor1,rms_curr1,rms_c1[70],rms_c1_avg,power1;
volatile float curr1_sample[500];
volatile uint16_t queue2_length,queue_length2;
char phase1_str[10],current1[10];

// variables used for current1 and phase1 calculation
uint32_t time7,time8,time9;
float phase2,power_factor2,rms_curr2,rms_c2[70],rms_c2_avg,power2;
volatile float curr2_sample[500];
volatile uint16_t queue3_length,queue_length3;
char phase2_str[10],current2[10];

//Variable used for http request and response
IPAddress server(10,42,0,78);  // numeric IP for Google (no DNS)
WiFiClient client;
char request_string[]="GET /GHpowermon/action.php/?cur=0.00&cur2=0.00&cur3=0.00&pha=000.0&pha2=000.0&pha3=000.0&vol=000.00&fre=00.0000&ds1=0&ds2=0&ds3=0&c=0 HTTP/1.1";
char server_response[255];
                              	 	/**************PORTAL VARIABLE*************/
String ssid;
String password;
String client_email;
String key;
char security_key[255];
int push=0;
									/*************FILE OPERATION VARIABLE***************/
char*           filepass = "password.txt";
char*           filessid = "ssid.txt";
char*           filekey="key.txt";
unsigned long   MaxSize = 63 * 1024; //62.5K is max file size
long            filehandle = -1;
long            RetVal;        //negative return value is an error
unsigned long   Offset = 0;
unsigned char   InputBuffer[100];
SlFsFileInfo_t  fileinfo;

 	 	 	 	 	 	 	 	 	/**************GLOBLE FUNCTIONS*************/
void PinMuxConfig(void);           	//function used to configure multiplexed GPIO pins
void portal(void);					//function used to display portal and handle portal operation in coolTerm GUI
void portal_end(void);				//function used to print a particular parttern
void ADC_init(void);				//function which initialize all the channels of ADC module
unsigned long ADC_0(void);			//function which returns ADC value of channel 0
unsigned long ADC_1(void);			//function which returns ADC value of channel 1
unsigned long ADC_2(void);			//function which returns ADC value of channel 2
unsigned long ADC_3(void);			//function which returns ADC value of channel 3
void RTC_init(void);				//function which initialize real time clock and switch the task on every second
void RTC_INT(void);					//This function is real time clock interrupt handler
void FREQ_INT(void);				//This function is real time clock interrupt handler
void PHA1_INT(void);				//This function is real time clock interrupt handler
void PHA2_INT(void);				//This function is real time clock interrupt handler
void PUSH_INT(void);				//This function is real time clock interrupt handler
void SAMPLE_INT(void);				//This function is real time clock interrupt handler
void SAMPLE_init(void);				//function initialize and configure timer 1 for genration of sample frequency
void printWifiStatus(void);			//fuction which prints the status of conncted wifi
void clear_Buffer(void);			//function which clears the buffer which is used in file operation
void file_init(void);               //function which read files and update variables of  like ssid, password, user email etc.
void INT_init(void);     			//function used to initialize and configure GPIO interrupt
void inits(void);					//function which calls all initialzing function

void PinMuxConfig(void)
{
	//
    // Set unused pins to PIN_MODE_0 with the exception of JTAG pins 16,17,19,20
    // PIN_MODE_0 is also a GPIO mode
    PinModeSet(PIN_05, PIN_MODE_0);
    PinModeSet(PIN_08, PIN_MODE_0);
    PinModeSet(PIN_53, PIN_MODE_0);
    PinModeSet(PIN_55, PIN_MODE_0);
    PinModeSet(PIN_57, PIN_MODE_0);
    PinModeSet(PIN_60, PIN_MODE_0);
    PinModeSet(PIN_61, PIN_MODE_0);
    PinModeSet(PIN_62, PIN_MODE_0);
    PinModeSet(PIN_63, PIN_MODE_0);
    PinModeSet(PIN_15, PIN_MODE_0);
    PinModeSet(PIN_04, PIN_MODE_0);

    //
    // Enable Peripheral Clocks
    //
    PRCMPeripheralClkEnable(PRCM_TIMERA0, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA1, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA2, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA3, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_ADC, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA1, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA2, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA3, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_UARTA0, PRCM_RUN_MODE_CLK);
    //
       // Configure PIN_06 for TimerCP6 GT_CCP06
       //
       PinTypeTimer(PIN_06, PIN_MODE_13);

       //
       // Configure PIN_07 for TimerCP7 GT_CCP07
       //
       PinTypeTimer(PIN_07, PIN_MODE_13);

    //
    // Configure PIN_59 for ADC0 ADC_CH2
    //
    PinTypeADC(PIN_59, PIN_MODE_255);

    //
    // Configure PIN_58 for ADC0 ADC_CH1
    //
    PinTypeADC(PIN_58, PIN_MODE_255);
    PinTypeADC(PIN_57, PIN_MODE_255);
    PinTypeADC(PIN_60, PIN_MODE_255);
    //
    // Configure PIN_64 for GPIO Output
    //red_led
    PinTypeGPIO(PIN_64, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x2, GPIO_DIR_MODE_OUT);

    //
    // Configure PIN_01 for GPIO Output
    //yellow_led
    PinTypeGPIO(PIN_01, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x4, GPIO_DIR_MODE_OUT);

    //
    // Configure PIN_02 for GPIO Output
    //green_led
    PinTypeGPIO(PIN_02, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x8, GPIO_DIR_MODE_OUT);

    //
    // Configure PIN_05 for GPIO Input
    //
    PinTypeGPIO(PIN_05, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA2_BASE, 0x40, GPIO_DIR_MODE_IN);

    //
    // Configure PIN_18 for GPIO Input
    //
    PinTypeGPIO(PIN_18, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA3_BASE, 0x10, GPIO_DIR_MODE_IN);



    //
}


void portal(void)
{
	String incoming,outgoing;
	char option;
	start_portal:
	Serial.flush();
	Serial.println("              ******************************************************************************");
	Serial.println("                                 WELCOME TO EYANTRA'S SMART PLUG PORTAL");
	Serial.println("              ******************************************************************************");
	if(security_key[0]!='\0')
	{
		Serial.println("Device is password protected ...");
		pass_enter:
		Serial.print("Enter password>");
		while(Serial.available()==0)
		{};
		incoming=Serial.readString();
		if(incoming==security_key)
		{
			portal_end();
			goto main_menu;
		}
		else
		{
			Serial.println("Wrong password... :-(");
			Serial.flush();
			goto pass_enter;
		}
	}
	else
    {
		main_menu:
		Serial.flush();
		Serial.println("Choose following options for configuration:-");
		Serial.println("1) Wifi-Configuration");
		Serial.println("2) Email-Configuration");
		Serial.println("3) Mode Configuration");
		Serial.println("4) Security Options");
		Serial.println("5) Signout from portal");
		Serial.println("Choose option>");
		while(Serial.available()==0)
		{};
		option=Serial.read();
		option_selected:
		switch((int)(option-48))
		{
		case 1:
			Serial.println("Choose following options for Wifi-configuration:-");
			Serial.println("1) Change SSID");
			Serial.println("2) Change Password");
			Serial.println("3) Change Network Mode");
			Serial.println("4) Go to main menu");
			Serial.println("Choose option>");
			while(Serial.available()==0)
			{};
			option=Serial.read();
			switch((int)(option-48))
			{
			case 1:
				Serial.println("Enter SSID of your wifi-network>");
				while(Serial.available()==0)
				{};
				incoming=Serial.readString();
				RetVal = sl_FsOpen((unsigned char *)filessid,FS_MODE_OPEN_WRITE,NULL,&filehandle);
				RetVal= sl_FsWrite(filehandle,Offset,(unsigned char *)incoming.buffer,incoming.length());
				RetVal= sl_FsClose(filehandle,NULL,NULL,0);
				RetVal = sl_FsOpen((unsigned char *)filessid,FS_MODE_OPEN_READ,NULL,&filehandle);
				RetVal= sl_FsGetInfo((unsigned char *)filessid,0,&fileinfo);
				RetVal= sl_FsRead(filehandle,Offset,(unsigned char *)InputBuffer,fileinfo.FileLen);
				RetVal= sl_FsClose(filehandle,NULL,NULL,0);
				Serial.print("Congratulation!!! your SSID has been changed to '");
				Serial.print((char *)InputBuffer);
				Serial.println("'");
				option='1';
				clear_buffer();
				portal_end();
				goto option_selected;
				break;

			case 2:
				Serial.println("Enter Password of your Wifi network>");
				while(Serial.available()==0)
				{};
				incoming=Serial.readString();
				RetVal = sl_FsOpen((unsigned char *)filepass,FS_MODE_OPEN_WRITE,NULL,&filehandle);
				RetVal=sl_FsWrite(filehandle,Offset,(unsigned char *)incoming.buffer,incoming.length());
				RetVal=sl_FsClose(filehandle,NULL,NULL,0);
				RetVal = sl_FsOpen((unsigned char *)filepass,FS_MODE_OPEN_READ,NULL,&filehandle);
				RetVal=sl_FsGetInfo((unsigned char *)filepass,0,&fileinfo);
				RetVal=sl_FsRead(filehandle,Offset,(unsigned char *)InputBuffer,fileinfo.FileLen);
				RetVal=sl_FsClose(filehandle,NULL,NULL,0);
				Serial.print("Congratulation!!! your password has been changed to '");
				Serial.print((char *)InputBuffer);
				Serial.println("'");
				option='1';
				clear_buffer();
				portal_end();
				goto option_selected;
				break;

			case 3:
				Serial.println("You want to run machine on:-");
				Serial.println("1) Local Network");
				Serial.println("2) Internet");
				Serial.println("Choose option>");
				while(Serial.available()==0)
				{};
				option=Serial.read();
				if((int)(option-48)==1)
				{
					Serial.println("Enter your host IP>");

				}
				else if((int)(option-48)==2)
				{
					Serial.println("Under construction");
				}
				Serial.println("Congraulation!!! you have sucssesfully changed your network mode ");
				option='1';
				portal_end();
				goto option_selected;
				break;

			case 4:
				portal_end();
				goto main_menu;
				break;
			default:
				Serial.println("Wrong option selected rechoose your option");
				option='1';
				goto option_selected;
				break;
			}
				break;

			case 2:
				Serial.println("Enter the email address to which device will send information");
				Serial.print("Email address>");
				while(Serial.available()==0)
				{};
				incoming=Serial.readString();
				client_email=incoming;
				Serial.print("Congratuation user email ID is modified to '");
				Serial.print(client_email);
				Serial.println("'");
				portal_end();
				goto main_menu;
				break;

			case 3:
				Serial.println("Select mode of operation for your device:-");
				Serial.println("1) Wireless Mode");
				Serial.println("2) Serial communication Mode");
				while(Serial.available()==0)
				{};
				option=Serial.read();
				if(option=='1')
				{
					outgoing=String("Wireless mode");
				}
				else if(option=='2')
				{
					outgoing=String("Serial communication mode");
				}
				Serial.print("Congratulation your mode of opertaion has been configured to '");
				Serial.print(outgoing);
				Serial.println("'");
				portal_end();
				goto main_menu;
				break;
			case 4:

				break;

			case 5:
				Serial.println("              ******************************************************************************");
				Serial.println("                                 THANK YOU FOR USING EYANTRA'S SMART PLUG");
				Serial.println("                            DEVELOPED BY:- ABHISHEk ACHARYA & AVILASH MOHANTY");
				Serial.println("              ******************************************************************************");
				break;

			default:
				Serial.println("Sorry wrong option entered.... please choose available options");
				portal_end();
				goto main_menu;
				break;
		}
   }
}



void portal_end(void)
{
	Serial.println("");
	Serial.println("");
	Serial.println("");
	Serial.println("              ******************************************************************************");
	Serial.println("");
	Serial.println("");
}



void ADC_init(void)
{
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_0)!=0)						//flush the FIFO registers of ADC_CH_1 and
		ADCFIFORead(ADC_BASE,ADC_CH_0);							//ADC_CH_2 if it is not empty
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_1);
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)						//flush the FIFO registers of ADC_CH_1 and
		ADCFIFORead(ADC_BASE,ADC_CH_2);							//ADC_CH_2 if it is not empty
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_3)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_3);
	ADCTimerConfig(ADC_BASE,2^17);								//configures ADC_Timer with 2^17 resolution
	ADCTimerEnable(ADC_BASE);
	ADCEnable(ADC_BASE);										//Enables gloable ADC
	ADCChannelEnable(ADC_BASE,ADC_CH_0);						//for cur2 measurement
	ADCChannelEnable(ADC_BASE,ADC_CH_1);						//for cur1 measurement
	ADCChannelEnable(ADC_BASE,ADC_CH_2);						//for vol measurement
	ADCChannelEnable(ADC_BASE,ADC_CH_3);						//for cur3 measurement

}
unsigned long ADC_2(void)
{
	unsigned long val;
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)						//flush the FIFO registers of ADC_CH_1 and
		ADCFIFORead(ADC_BASE,ADC_CH_2);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_2);
			break;
		}
	}
	val=val & 0x3FFF;
	val = val >> 2;
	return(val);

}



unsigned long ADC_0(void)
{
	unsigned long val;
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_0)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_0);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_0)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_0);
			break;
		}
	}
	val=val & 0x3FFF;
	val = val >> 2;
	return(val);
}




unsigned long ADC_1(void)
{
	unsigned long val;
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_1);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_1);
			break;
		}
	}
	val=val & 0x3FFF;
	val = val >> 2;
	return(val);
}



unsigned long ADC_3(void)
{
	unsigned long val;
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_3)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_3);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_3)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_3);
			break;
		}
	}
	val=val & 0x3FFF;
	val = val >> 2;
	return(val);
}


void RTC_INT(void)
{
	TimerIntClear(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);              //clears the timer0 interrupt flag
	sec++;
	task_flag=(sec%4+1);
	if(task_flag==1)
	{
		TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);			//Enables the interrupt for timer1
	}
	else
		TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);    		//Disable the timer1 interrupt

}

void RTC_init(void)
{
	TimerDisable(TIMERA0_BASE,TIMER_BOTH);					//Disables timer before configuring
	TimerConfigure(TIMERA0_BASE,TIMER_CFG_A_PERIODIC_UP);		//configures timer0 as split mode
	TimerLoadSet(TIMERA0_BASE,TIMER_BOTH,80000000);				//loading 4000 as the top value of timerA(Timer0)
	TimerPrescaleSet(TIMERA0_BASE,TIMER_A,0x00);			//clock frequency of timer is configured as (80Mhzprescale)
	TimerIntEnable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);		//Timeout interrupt is enabled for TimerA(Timer0)
	TimerIntRegister(TIMERA0_BASE,TIMER_BOTH,&RTC_INT);	//Interrupt handler is registered for TimerA(Timer0)
	TimerEnable(TIMERA0_BASE,TIMER_BOTH);						//TimerA of Timer0 has been enabled
}

/*
 * Function Name:		FREQ_INT
 * Variable Used:		l,queue_len,feq,volt
 * Discription:			This function will be called whenever frequency signal generates GPIO interrupt at pin05.
 * 						This function executes the task according to task flag assigned by real time clock. each task is described below:-
 * 						task1:
 * 							In this task function will read all the voltage sample data and calculate the rms value of signal. After
 * 							calculating rms of single cycle this function push this rms value in queue named "rms_v".
 * 						task2:
 * 							This task updates the frequency variable of program.
 * 						task3:
 * 							This task store the time stamp value of frequency signal which will be further used by phase callback.
 * 						task4:
 * 							In this task function reads the rms values of cycles from queue "rms_v"and calculate the average rms value
 * 							of voltage. This function also convert frequency and rms volatge value from float to string.
 */
void FREQ_INT(void)
{
	uint16_t l,queue_len;
	float frq,volt;
	time1=micros()-time2+135;
	time2=micros();
	if((time1>19000 && time1<21000))
	{
		frq=1/(time1*pow(10,-6));
		switch(task_flag)
		{
			case 1:											//voltage calculation;
				rms_volt=volt_sample[0];
				for(l=1;l<=queue1_length;l++)
				{
					if(volt_sample[l]>rms_volt)
						rms_volt=volt_sample[l];
					l++;
				}
				queue1_length=0;
				rms_volt=(rms_volt/sqrt(2));
				rms_volt=(rms_volt*(240/9.3)-2.5);
				rms_v[queue_length1]=rms_volt;
				queue_length1++;
				break;
			case 2:
				frequency=frq;
				break;
			case 3:													//phase calculation
				time3=micros();
				phase_flag1=1;
				phase_flag2=1;
				break;
			case 4:
				if(queue_length1>0)
				{
					queue_len=queue_length1;
					volt=0;
					while(queue_length1>0)
					{
						queue_length1--;
						volt=volt+rms_v[queue_length1];
					}
					queue_length1=0;
					rms_v_avg=(volt/queue_len);
					snprintf(voltage,10,"%f",rms_v_avg);
					snprintf(freq,10,"%f",frequency);
					request_string[93]=voltage[0];
					request_string[94]=voltage[1];
					request_string[95]=voltage[2];
					request_string[96]=voltage[3];
					request_string[97]=voltage[4];
					request_string[98]=voltage[5];
					request_string[104]=freq[0];
					request_string[105]=freq[1];
					request_string[106]=freq[2];
					request_string[107]=freq[3];
					request_string[108]=freq[4];
					request_string[109]=freq[5];
					request_string[110]=freq[6];
					if(connected_flag1==0)
						{
							request_string[61]='0';
							request_string[62]='0';
							request_string[63]='.';
							request_string[64]='0';
							request_string[65]='0';
							request_string[32]='0';
							request_string[33]='.';
							request_string[34]='0';
							request_string[35]='0';
						}
						if(connected_flag2==0)
						{
							request_string[72]='0';
							request_string[73]='0';
							request_string[74]='.';
							request_string[75]='0';
							request_string[76]='0';
							request_string[42]='0';
							request_string[43]='.';
							request_string[44]='0';
							request_string[45]='0';
						}
					server_flag=1;
				}
				break;
		}
	}
}

void PHA1_INT(void)
{
	uint16_t l,queue_len;
	float curr;
	time4=micros()-time5+123;
	time5=micros();
	if(time4>19000 && time4<21000)
	{
		switch(task_flag)
			{
				case 1:													//current calculation
					rms_curr1=curr1_sample[0];
					for(l=1;l<=queue2_length;l++)
					{
						if(curr1_sample[l]>rms_curr1)
							rms_curr1=curr1_sample[l];
						l++;
					}
					queue2_length=0;
					rms_curr1=((rms_curr1*(1000/66))/sqrt(2))*(1.232);
					rms_c1[queue_length2]=rms_curr1;
					queue_length2++;
					break;
				case 2:													//nothing to be done
					break;
				case 3:													//phase calculation
					if(phase_flag1==1)
					{
						time6=micros()-time3;
						phase1=((float)time6/20000)*360;
						phase1=phase1+36;
						if(phase1>360)
							phase1=phase1-360;
						power_factor1=cos((phase1/360)*2*pi);
						snprintf(phase1_str,10,"%f",phase1);
						request_string[61]=phase1_str[0];
						request_string[62]=phase1_str[1];
						request_string[63]=phase1_str[2];
						request_string[64]=phase1_str[3];
						request_string[65]=phase1_str[4];
						phase_flag1=0;
					}
					break;
				case 4:
					if(queue_length2>0)
					{
						queue_len=queue_length2;
						curr=0;
						while(queue_length2>0)
						{
							queue_length2--;
							curr=curr+rms_c1[queue_length2];
						}
						rms_c1_avg=(curr/queue_len);
						queue_length2=0;
						snprintf(current1,10,"%f",rms_c1_avg);
						request_string[32]=current1[0];
						request_string[33]=current1[1];
						request_string[34]=current1[2];
						request_string[35]=current1[3];
						power1=rms_v_avg*rms_c1_avg*power_factor1;
					}
					break;
			}
	}
}

void PHA2_INT(void)
{
	uint16_t l,queue_len;
	float curr;
	time7=micros()-time8+123;
	time8=micros();
	if(time7>19000 && time7<21000)
	{
		switch(task_flag)
			{
				case 1:													//current calculation
					rms_curr2=curr2_sample[0];
					for(l=1;l<=queue3_length;l++)
					{
						if(curr2_sample[l]>rms_curr2)
							rms_curr2=curr2_sample[l];
						l++;
					}
					queue3_length=0;
					rms_curr2=((rms_curr2*(1000/66))/sqrt(2))*(1.232);
					rms_c2[queue_length3]=rms_curr2;
					queue_length3++;
					break;
				case 2:													//nothing to be done
					break;
				case 3:													//phase calculation
					if(phase_flag2==1)
					{
						time9=micros()-time3;
						phase2=((float)time9/20000)*360;
						phase2=phase2+36;
						if(phase2>360)
							phase2=phase2-360;
						power_factor2=cos((phase2/360)*2*pi);
						snprintf(phase2_str,10,"%f",phase2);
						request_string[72]=phase2_str[0];
						request_string[73]=phase2_str[1];
						request_string[74]=phase2_str[2];
						request_string[75]=phase2_str[3];
						request_string[76]=phase2_str[4];
						phase_flag2=0;
					}
					break;
				case 4:
					if(queue_length3>0)
					{
						queue_len=queue_length3;
						curr=0;
						while(queue_length3>0)
						{
							queue_length3--;
							curr=curr+rms_c2[queue_length3];
						}
						rms_c2_avg=(curr/queue_len);
						queue_length3=0;
						snprintf(current2,10,"%f",rms_c2_avg);
						request_string[42]=current2[0];
						request_string[43]=current2[1];
						request_string[44]=current2[2];
						request_string[45]=current2[3];
						power2=rms_v_avg*rms_c2_avg*power_factor2;
					}
					break;
			}
	}
}


void PUSH_INT(void)
{
	push++;
}
/*
 * This function is a call back or interrupt handler function associated with Timer1 time out interrupt
 */
void SAMPLE_INT(void)
{
	TimerIntClear(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	curr1_sample[queue2_length]=ADC_1();
	volt_sample[queue1_length]=ADC_2();
	curr2_sample[queue3_length]=ADC_3();
	if((volt_sample[queue1_length]/4096)*1.65>0 && (volt_sample[queue1_length]/4096)*1.65<0.1)
		volt_sample[queue1_length]=0;
	else
		volt_sample[queue1_length]=((volt_sample[queue1_length]/4096)*1.68*10);
	curr1_sample[queue2_length]=((curr1_sample[queue2_length]/4096)*1.68);
	curr2_sample[queue3_length]=((curr2_sample[queue3_length]/4096)*1.68);
	if(queue1_length<500)
	{
		queue1_length++;
		PowerIN_flag=1;
	}
	else
		PowerIN_flag=0;
	if(PowerIN_flag==1)
	{
		if(connected_flag1==1)
			queue2_length++;
		if(connected_flag2==1)
			queue3_length++;
	}
	if(queue2_length>499)
		connected_flag1=0;
	else
		connected_flag1=1;
	if(queue3_length>499)
		connected_flag2=0;
	else
		connected_flag2=1;
	request_string[116]=(char)(connected_flag1+48);
	request_string[122]=(char)(connected_flag2+48);

}
/*
 * This function initialise and configure the timer1 used for sampling of the wave
 */
void SAMPLE_init(void)
{
	TimerDisable(TIMERA1_BASE,TIMER_A);						//Disables timer before configuring
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_SPLIT_PAIR);		//configures timer0 as split mode
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_A_PERIODIC_UP);	//configures timerA of timer0 as periodic up counter
	TimerLoadSet(TIMERA1_BASE,TIMER_A,4000);				//loading 4000 as the top value of timerA(Timer0)
	TimerPrescaleSet(TIMERA1_BASE,TIMER_A,0x00);			//clock frequency of timer is configured as (80Mhzprescale)
	TimerIntRegister(TIMERA1_BASE,TIMER_A,&SAMPLE_INT);		//Interrupt handler is registered for TimerA(Timer0)
	TimerEnable(TIMERA1_BASE,TIMER_A);
}
/*
 * This fuction used for printing the stats of connected Wi-FI.
 */
void printWifiStatus()
{
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  //--------------------------------------------------------------------------------------------------------------------------
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}
void clear_buffer(void)
{
	int u;
	for(u=0;u<=100;u++)
		InputBuffer[u]='\0';
}
/*
 * This function used to create the file if it is not present. This file also reads data present in the file
 * according to that it will update the RAM variables used for WI-Fi operation
 */
void file_init(void)
{
	sl_Start(NULL,NULL,NULL);

	RetVal = sl_FsOpen((unsigned char *)filekey,FS_MODE_OPEN_READ,NULL,&filehandle);
	Serial.println(RetVal);
	if(RetVal<0)
	{
		RetVal = sl_FsOpen((unsigned char *)filekey,FS_MODE_OPEN_CREATE(MaxSize , _FS_FILE_OPEN_FLAG_NO_SIGNATURE_TEST | _FS_FILE_OPEN_FLAG_COMMIT),NULL,&filehandle);
		Serial.println(RetVal);
		RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	}
	RetVal = sl_FsGetInfo((unsigned char *)filekey,0,&fileinfo);
	RetVal = sl_FsRead(filehandle,Offset,(unsigned char *)InputBuffer,fileinfo.FileLen);
	RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	key = String((const char *)InputBuffer);
	clear_buffer();

	RetVal = sl_FsOpen((unsigned char *)filessid,FS_MODE_OPEN_READ,NULL,&filehandle);
	Serial.println(RetVal);
	if(RetVal<0)
	{
		RetVal = sl_FsOpen((unsigned char *)filessid,FS_MODE_OPEN_CREATE(MaxSize , _FS_FILE_OPEN_FLAG_NO_SIGNATURE_TEST | _FS_FILE_OPEN_FLAG_COMMIT),NULL,&filehandle);
		Serial.println(RetVal);
		RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	}
	RetVal = sl_FsGetInfo((unsigned char *)filessid,0,&fileinfo);
	RetVal = sl_FsRead(filehandle,Offset,(unsigned char *)InputBuffer,fileinfo.FileLen);
	RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	ssid=String((const char *)InputBuffer);
	clear_buffer();

	RetVal = sl_FsOpen((unsigned char *)filepass,FS_MODE_OPEN_READ,NULL,&filehandle);
	Serial.println(RetVal);
	if(RetVal<0)
	{
		RetVal = sl_FsOpen((unsigned char *)filepass,FS_MODE_OPEN_CREATE(MaxSize , _FS_FILE_OPEN_FLAG_NO_SIGNATURE_TEST | _FS_FILE_OPEN_FLAG_COMMIT),NULL,&filehandle);
		Serial.println(RetVal);
		RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	}
	RetVal = sl_FsGetInfo((unsigned char *)filepass,0,&fileinfo);
	RetVal = sl_FsRead(filehandle,Offset,(unsigned char *)InputBuffer,fileinfo.FileLen);
	RetVal = sl_FsClose(filehandle,NULL,NULL,0);
	password=String((const char *)InputBuffer);
	clear_buffer();
}
/*
 * This function initialize and configure the GPIO interrupt for frequency and phase signal calculation
 */
void INT_init(void)
{
	attachInterrupt(7,FREQ_INT,RISING);
	attachInterrupt(19,PHA1_INT,RISING);
	attachInterrupt(18,PHA2_INT,RISING);
	//attachInterrupt(17,PHA3_INT,RISING);
	IntEnable(FAULT_SYSTICK);
}
/*
 * This function will be called whenever the push button has be pressed by the user.
 * This function do requiste setting before calling portal function and upadte the system data after returning
 * from portal function.
 */
void portal_call(void)
{
	detachInterrupt(PUSH1);
	WiFi.disconnect();
	TimerIntDisable(TIMERA1_BASE,TIMER_A);
	TimerIntDisable(TIMERA0_BASE,TIMER_BOTH);
	portal();
	file_init();
	Serial.print("Attempting to connect to Network named: ");
	Serial.println(ssid);
	WiFi.begin(ssid.buffer, password.buffer);
	while ( WiFi.status() != WL_CONNECTED)
	{
		Serial.print(".");
		delay(300);
	}
	Serial.println("\nYou're connected to the network");
	Serial.println("Waiting for an ip address");
	while (WiFi.localIP() == INADDR_NONE)
	{
	Serial.print(".");
    delay(300);
	}
	Serial.println("\nIP Address obtained");
	printWifiStatus();
	TimerIntEnable(TIMERA1_BASE,TIMER_A);
	TimerIntEnable(TIMERA0_BASE,TIMER_BOTH);
	push=0;
	attachInterrupt(PUSH1,PUSH_INT,RISING);
}
void inits(void)
{
	IntMasterDisable();
	IntVTableBaseSet((unsigned long)&g_pfnVectors[0]);
	PinMuxConfig();												//Pin mux setting for the project
	ADC_init();
	SAMPLE_init();
	INT_init();
	RTC_init();
	IntMasterEnable();
}
void setup()
{
	Serial.begin(9600);
	file_init();
	attachInterrupt(PUSH1,PUSH_INT,RISING);
	//----------------------------------------------------------------------------------------------------------------------------

	Serial.print("Attempting to connect to Network named: ");
	  Serial.println(ssid);
	  WiFi.begin(ssid.buffer, password.buffer);
	  while ( WiFi.status() != WL_CONNECTED)
	  {
	    Serial.print(".");
	    if(push>0)
	    	portal_call();
	    delay(300);
	  }
	  Serial.println("\nYou're connected to the network");
	  Serial.println("Waiting for an ip address");
	  while (WiFi.localIP() == INADDR_NONE)
	  {
	    Serial.print(".");
	    if(push>0)
	   	    portal_call();
	    delay(300);
	  }

	  Serial.println("\nIP Address obtained");
	  printWifiStatus();

	  Serial.println("\nStarting connection to server...");
	  // if you get a connection, report back via serial:
	  if (client.connect(server, 80)) {
	    Serial.println("connected to server");
	    // Make a HTTP request:
	    Serial.println(request_string);
	    client.println(request_string);
	    client.println("Host:10.42.0.78");
	    client.println("Connection: close");
	    client.println();
	  }
//----------------------------------------------------------------------------------------------------------------------------------
	  inits();
}
void loop()
{
	if(server_flag==1 && task_flag==4)
	{
		TimerIntDisable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);
		TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
		Serial.begin(9600);
		Serial.println("hii");

		Serial.println("\nStarting connection to server...");
		// if you get a connection, report back via serial:
		client.stop();
		if (client.connect(server, 80)) {
			Serial.println("connected to server");
			    // Make a HTTP request:
			Serial.println(request_string);
			client.println(request_string);
			client.println("Host:10.42.0.78");
			client.println("Connection: close");
			client.println();
		}
		int o;
		while(client.available()==0)
		{}
		while(client.available()!=0)
		{
			server_response[o++]=client.read();
		}
		Serial.println(server_response);
		if((int)(server_response[(o-3)]-48)==0)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x2, 0x0);
		}
		else if((int)(server_response[(o-3)]-48)==1)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x2, 0x2);
		}
		if((int)(server_response[(o-2)]-48)==0)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x4, 0x0);
		}
		else if((int)(server_response[(o-2)]-48)==1)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x4, 0x4);
		}
		if((int)(server_response[(o-1)]-48)==0)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x8, 0x0);
		}
		else if((int)(server_response[(o-1)]-48)==1)
		{
			GPIOPinWrite(GPIOA1_BASE, 0x8, 0x8);
		}
		client.flush();
		server_flag=0;
		RTC_init();
		SAMPLE_init();
	}
	if(push>0)
		{
			portal_call();
		}

}



