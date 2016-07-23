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
#define volt_calibration 1
#define curr_calibration 1
#define	ADC_1_PIN ADC_CH_1
#define	ADC_2_PIN ADC_CH_2
#define INT_1_PIN GPIO_INT_PIN_6
#define INT_2_PIN GPIO_INT_PIN_4
#define INT_1_PORT GPIOA1_BASE
#define INT_2_PORT GPIOA3_BASE
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
volatile unsigned long sec=0;
volatile int task_flag=0,on_flag=0,connected_flag=0,phase_flag=0,server_flag=0;
volatile double volt_sample[500],rms_volt,rms_curr,rms_v[30],rms_c[30],phase_avg[30],rms_v_avg=0,rms_c_avg=0;
float curr_sample[500];
volatile double frequency,phase,time1,time2,time3,power_factor;
volatile int queue1_length=0,queue2_length=0,queue_length1=0,queue_length2=0,phase_index=0;
volatile char phase_c='\0';
volatile unsigned long int i,j,k,l;
char voltage[10],freq[10],phase_str[10];
char ssid[] = "pass:123456789";
char password[] = "123456789";
IPAddress server(192,168,101,24);  // numeric IP for Google (no DNS)
String string1,string2,string3,string4,string5,string6,string7,string8,string9,stringThree;
char server_response;

WiFiClient client;
 	 	 	 	 	 	 	 	 	/**************GLOBLE FUNCTIONS*************/
void RTC_init(void);
void INT_init(void);
void SAMPLE_init(void);
void ADC_init(void);
unsigned long ADC_2(void);
void INT_1(void);
void INT_2(void);
void SAMPLE_INT(void);
void RTC_INT(void);
void PinMuxConfig(void);

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


void ADC_init(void)
{
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)						//flush the FIFO registers of ADC_CH_1 and
		ADCFIFORead(ADC_BASE,ADC_CH_2);							//ADC_CH_2 if it is not empty
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_1);
	ADCTimerConfig(ADC_BASE,2^17);								//configures ADC_Timer with 2^17 resolution
	ADCTimerEnable(ADC_BASE);
	ADCEnable(ADC_BASE);										//Enables gloable ADC
	ADCChannelEnable(ADC_BASE,ADC_CH_1);
	ADCChannelEnable(ADC_BASE,ADC_CH_2);

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


void RTC_INT(void)
{
	TimerIntClear(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);
	sec++;
	task_flag=(sec%4+1);
}


void RTC_init(void)
{
	TimerDisable(TIMERA0_BASE,TIMER_BOTH);					//Disables timer before configuring
	TimerConfigure(TIMERA0_BASE,TIMER_CFG_A_PERIODIC_UP);		//configures timer0 as split mode
	TimerLoadSet(TIMERA0_BASE,TIMER_BOTH,20000000);				//loading 4000 as the top value of timerA(Timer0)
	TimerPrescaleSet(TIMERA0_BASE,TIMER_A,0x00);			//clock frequency of timer is configured as (80Mhz/prescale)
	TimerIntEnable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);		//Timeout interrupt is enabled for TimerA(Timer0)
	TimerIntRegister(TIMERA0_BASE,TIMER_BOTH,&RTC_INT);	//Interrupt handler is registered for TimerA(Timer0)
	TimerEnable(TIMERA0_BASE,TIMER_BOTH);						//TimerA of Timer0 has been enabled
}


void INT_1(void)       											//Interrupt handler for interrupts at GPIOA1
{
	GPIOIntDisable(GPIOA1_BASE,GPIO_INT_PIN_6);
	GPIOIntClear(GPIOA1_BASE,GPIO_INT_PIN_6);					//Nessasary to clear the interrupt(EDGE) other wise program will execute interrupt fuction only
	double volt=0;
	int queue_len=0,l=0;
	switch(task_flag)
	{
		case 1:													//voltage calculation;
			TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			rms_volt=volt_sample[0];
			for(l=1;l<=queue1_length;l++)
			{
				if(volt_sample[l]>rms_volt)
					rms_volt=volt_sample[l];
				l++;
			}
			queue1_length=0;
			rms_volt=(rms_volt/sqrt(2));
			rms_volt=rms_volt*10.2;
			rms_volt=rms_volt*(240/9.3);
			if(rms_volt>200 && rms_volt<300)
			{rms_v[queue_length1]=rms_volt;
			queue_length1++;}
			break;
		case 2:													//frequency calculation
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			time1=(TimerValueGet(TIMERA0_BASE,TIMER_A)-time2);
			time2=TimerValueGet(TIMERA0_BASE,TIMER_A);
			time1=time1*12.5*pow(10,-9);
			frequency=(1/time1);
			if(frequency>40 && frequency<60)
				frequency=frequency;
			else
				frequency=50;
			break;
		case 3:													//phase calculation
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			time1=TimerValueGet(TIMERA0_BASE,TIMER_A);
			phase_flag=1;
			break;
		case 4:
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
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
				server_flag=1;
			}
			break;
	}
	k++;
	delayMicroseconds(100);
	GPIOIntEnable(GPIOA1_BASE,GPIO_INT_PIN_6);
}



void INT_2(void)       										 	//Interrupt handler for interrupts at GPIOA3
{
	GPIOIntClear(GPIOA3_BASE,GPIO_INT_PIN_4);					//Nessasary to clear the interrupt(EDGE) other wise program will execute interrupt fuction only
	int queue_len=0,l=0;
	double curr=0;
	switch(task_flag)
	{
		case 1:													//current calculation
			TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			rms_curr=curr_sample[0];
			for(l=1;l<=queue2_length;l++)
			{
				if(curr_sample[l]>rms_curr)
					rms_curr=curr_sample[l];
				l++;
			}
			queue2_length=0;
			rms_curr=(rms_curr*10)/sqrt(2);
			break;
		case 2:													//nothing to be done
			break;
		case 3:													//phase calculation
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			if(phase_flag==1)
			{
				time2=TimerValueGet(TIMERA0_BASE,TIMER_A);
				time3=time2-time1;
				phase=time3*12.5*pow(10,-9);
				phase=(phase/20)*1000*360;
				if(phase>0 && phase<90)
					phase_c='P';
				else if(phase>270 && phase<360)
					phase_c='A';
				power_factor=cos((phase/360)*2*pi);
				snprintf(phase_str,10,"%f",phase);
				phase_flag=0;
			}
			break;
		case 4:
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			/*if(queue_length1>0)
			{
				queue_len=queue_length2;
				curr=0;
				while(queue_length1>0)
				{
					queue_length1--;
					curr=curr+rms_c[queue_length2];
				}
				queue_length2=0;
				rms_c_avg=(curr/queue_len);
			}*/
			break;
	}
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);
	j++;
}

void INT_init(void)												//Interrupt configuration fuction
{
	GPIOIntTypeSet(GPIOA1_BASE,GPIO_INT_PIN_6,GPIO_RISING_EDGE); //Interrupt configuration at pin05(GPIO14) for Frequency calculation
	GPIOIntTypeSet(GPIOA3_BASE,GPIO_INT_PIN_4,GPIO_RISING_EDGE); //Interrupt configuration at pin18(GPIO28) for Phase calculation
	GPIOIntRegister(GPIOA1_BASE,&INT_1);   						//Registering the interrupt handler for Interrupts at port GPIOA1
	GPIOIntRegister(GPIOA3_BASE,&INT_2);   						//Registering the interrupt handler for Interrupts at port GPIOA3
	GPIOIntEnable(GPIOA1_BASE,GPIO_INT_PIN_6);   				//Enables the external interrupt at pin05(GPIO14)
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);					//Enables the external interrupt at pin18(GPIO28)
	IntEnable(FAULT_SYSTICK);
}

void SAMPLE_INT(void)
{
	TimerIntClear(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	curr_sample[queue2_length]=ADC_1();
	volt_sample[queue1_length]=ADC_2();
	volt_sample[queue1_length]=((volt_sample[queue1_length]/4096)*1.68);
	curr_sample[queue2_length]=((curr_sample[queue2_length]/4096)*1.68);
	queue1_length++;
	queue2_length++;
	i++;
}

void SAMPLE_init(void)
{
	TimerDisable(TIMERA1_BASE,TIMER_A);						//Disables timer before configuring
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_SPLIT_PAIR);		//configures timer0 as split mode
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_A_PERIODIC_UP);	//configures timerA of timer0 as periodic up counter
	TimerLoadSet(TIMERA1_BASE,TIMER_A,4000);				//loading 4000 as the top value of timerA(Timer0)
	TimerPrescaleSet(TIMERA1_BASE,TIMER_A,0x00);			//clock frequency of timer is configured as (80Mhz/prescale)
	TimerIntRegister(TIMERA1_BASE,TIMER_A,&SAMPLE_INT);		//Interrupt handler is registered for TimerA(Timer0)
	TimerEnable(TIMERA1_BASE,TIMER_A);
}

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


void setup()
{
	//----------------------------------------------------------------------------------------------------------------------------
	/*Serial.begin(9600);
	Serial.print("Attempting to connect to Network named: ");
	Serial.println(ssid);
	WiFi.begin(ssid, password);
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

	string1 = String("GET /GHpowermon/action.php/?cur=");
	string2 = String("0");
	string3 = String("&vol=");
	string4 = String("0");
	string5 = String("&fre=");
	string6 = String("0");
	string7 = String("&pha=");
	string8 = String("0");
	string9 = String(" HTTP/1.1");
	stringThree = String();
	stringThree=string1+string2+string3+string4+string5+string6+string7+string8+string9;

	Serial.println("\nStarting connection to server...");
	// if you get a connection, report back via serial:
	if (client.connect(server, 80)) {
	  Serial.println("connected to server");
	  // Make a HTTP request:
	  Serial.println(stringThree);
	  client.println(stringThree);
	  client.println("Host:192.168.0.120");
	  client.println("Connection: close");
	  client.println();
	}*/
//----------------------------------------------------------------------------------------------------------------------------------
	IntMasterDisable();
	IntVTableBaseSet((unsigned long)&g_pfnVectors[0]);
	PinMuxConfig();												//Pin mux setting for the project
	ADC_init();
	SAMPLE_init();
	INT_init();
	RTC_init();
	TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	IntMasterEnable();
	GPIOPinWrite(GPIOA1_BASE,0x2,0x2);
}
void loop()
{
	if(task_flag==5 && server_flag==1)
	{
		TimerIntDisable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);
		Serial.begin(9600);
		Serial.println("hii");
		string1 = String("GET /GHpowermon/action.php/?cur=");
		string2 = String("0");
		string3 = String("&vol=");
		string4 = String(voltage);
		string5 = String("&fre=");
		string6 = String(freq);
		string7 = String("&pha=");
		string8 = String(phase_str);
		string9 = String(" HTTP/1.1");
		stringThree = String();
		stringThree=string1+string2+string3+string4+string5+string6+string7+string8+string9;

		Serial.println("\nStarting connection to server...");
		// if you get a connection, report back via serial:
		client.stop();
		if (client.connect(server, 80)) {
			Serial.println("connected to server");
			    // Make a HTTP request:
			Serial.println(stringThree);
			client.println(stringThree);
			client.println("Host:192.168.101.24");
			client.println("Connection: close");
			client.println();
		}
		server_flag=0;
		 RTC_init();
		 SAMPLE_init();
	}

}

