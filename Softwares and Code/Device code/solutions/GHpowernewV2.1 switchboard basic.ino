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
uint32_t sec,task_flag,PowerIN_flag,connected_flag1,connected_flag2,phase_flag1,phase_flag2;        // Variable used by every task

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

uint32_t i;
IPAddress server(192,168,43,198);  // numeric IP for Google (no DNS)
String string1,string2,string3,string4,string5,string6,string7,string8,string9,stringThree;
int x=0;
char server_response[255];
                              	 	/**************PORTAL VARIABLE*************/
String ssid=String("cc3200");
String password=String("hello123");
String client_email;
char security_key[50];

WiFiClient client;
 	 	 	 	 	 	 	 	 	/**************GLOBLE FUNCTIONS*************/
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
	TimerIntClear(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);
	sec++;
	task_flag=(sec%4+1);
	if(task_flag==1)
		TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	else
		TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);

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
			case 1:						//voltage calculation;
				rms_volt=volt_sample[0];
				for(l=1;l<=queue1_length;l++)
				{
					if(volt_sample[l]>rms_volt)
						rms_volt=volt_sample[l];
					l++;
				}
				queue1_length=0;
				rms_volt=(rms_volt/sqrt(2));
				rms_volt=(rms_volt*(240/9.3)-2);
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
					//server_flag=1;
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
					rms_curr1=((rms_curr1*10)/sqrt(2))*(1.232);
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
					rms_curr2=((rms_curr2*10)/sqrt(2))*(1.232);
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
						power2=rms_v_avg*rms_c2_avg*power_factor2;
					}
					break;
			}
	}
}

void SAMPLE_INT(void)
{
	TimerIntClear(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	curr1_sample[queue2_length]=ADC_1();
	volt_sample[queue1_length]=ADC_2();
	curr2_sample[queue3_length]=ADC_3();
	if((volt_sample[queue1_length]/4096)*1.65>0 && (volt_sample[queue1_length]/4096)*1.65<0.1)
		volt_sample[queue1_length]=0;
	else
		volt_sample[queue1_length]=((volt_sample[queue1_length]/4096)*1.68*10.08);
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
}

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

void INT_init(void)
{
	attachInterrupt(7,FREQ_INT,RISING);
	attachInterrupt(19,PHA1_INT,RISING);
	attachInterrupt(18,PHA2_INT,RISING);
	//attachInterrupt(17,PHA3_INT,RISING);
}
void setup()
{
	PinMuxConfig();
	INT_init();
	RTC_init();
	SAMPLE_init();
	ADC_init();
}
void loop()
{

}

