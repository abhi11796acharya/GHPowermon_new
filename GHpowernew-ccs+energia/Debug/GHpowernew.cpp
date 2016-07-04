#line 1 "E:/Texas instruments project-ccs/GHpowernew/GHpowernew.ino"






									







                                    
#define volt_calibration 1
#define curr_calibration 1
#define	ADC_1_PIN ADC_CH_1
#define	ADC_2_PIN ADC_CH_2
#define INT_1_PIN GPIO_INT_PIN_6
#define INT_2_PIN GPIO_INT_PIN_4
#define INT_1_PORT GPIOA1_BASE
#define INT_2_PORT GPIOA3_BASE
#define pi 3.14159265358979323846

#include "commonheader.h"
#include "stdlib.h"
#include "Energia.h"
#ifndef __CC3200R1M1RGC__

#include <SPI.h>
#endif
#include <WiFi.h>
#include "Energia.h"

unsigned long ADC_1(void);
void printWifiStatus();
void setup();
void loop();

#line 34
extern void (* const g_pfnVectors[])(void); 
volatile unsigned long long int sec=0;
volatile int task_flag=0,on_flag=0,connected_flag=0,phase_flag=0;
volatile double volt_sample[500],curr_sample[500],rms_volt,rms_curr,rms_v[70],rms_c[70],rms_v_avg=0,rms_c_avg=0;
volatile double frequency,phase,time1,time2,time3,power_factor;
volatile int queue1_length=0,queue2_length=0,queue_length1=0,queue_length2=0;
volatile char phase_c='\0';
volatile unsigned long long int i,j,k,a,b;
char ssid[] = "cc3200demo";
char password[] = "cc3200demo";

char server[] = "energia.nu";    
WiFiClient client;


 	 	 	 	 	 	 	 	 	
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

    
    
    
    PRCMPeripheralClkEnable(PRCM_TIMERA0, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA1, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA2, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_TIMERA3, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_ADC, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA1, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA2, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_GPIOA3, PRCM_RUN_MODE_CLK);
    PRCMPeripheralClkEnable(PRCM_UARTA0, PRCM_RUN_MODE_CLK);
    
       
       
       PinTypeTimer(PIN_06, PIN_MODE_13);

       
       
       
       PinTypeTimer(PIN_07, PIN_MODE_13);

    
    
    
    PinTypeADC(PIN_59, PIN_MODE_255);

    
    
    
    PinTypeADC(PIN_58, PIN_MODE_255);

    
    
    
    PinTypeGPIO(PIN_64, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x2, GPIO_DIR_MODE_OUT);

    
    
    
    PinTypeGPIO(PIN_01, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x4, GPIO_DIR_MODE_OUT);

    
    
    
    PinTypeGPIO(PIN_02, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA1_BASE, 0x8, GPIO_DIR_MODE_OUT);

    
    
    
    PinTypeGPIO(PIN_05, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA2_BASE, 0x40, GPIO_DIR_MODE_IN);

    
    
    
    PinTypeGPIO(PIN_18, PIN_MODE_0, false);
    GPIODirModeSet(GPIOA3_BASE, 0x10, GPIO_DIR_MODE_IN);

    
  }


void ADC_init(void)
{
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)						
		ADCFIFORead(ADC_BASE,ADC_CH_2);							
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_1);
	ADCTimerConfig(ADC_BASE,2^17);								
	ADCEnable(ADC_BASE);										
}



unsigned long ADC_2(void)
{
	unsigned long val;
	ADCTimerEnable(ADC_BASE);
	ADCChannelEnable(ADC_BASE,ADC_CH_2);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_2);
			break;
		}
	}
	ADCChannelDisable(ADC_BASE,ADC_CH_2);
	ADCTimerDisable(ADC_BASE);
	val=val & 0x3FFF;
	val = val >> 2;
	return(val);

}



unsigned long ADC_1(void)
{
	unsigned long val;
	ADCTimerEnable(ADC_BASE);
	ADCChannelEnable(ADC_BASE,ADC_CH_1);
	while(1)
	{
		if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		{
			val=ADCFIFORead(ADC_BASE,ADC_CH_1);
			break;
		}
	}
	ADCChannelDisable(ADC_BASE,ADC_CH_1);
	ADCTimerDisable(ADC_BASE);
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
	TimerDisable(TIMERA0_BASE,TIMER_BOTH);					
	TimerConfigure(TIMERA0_BASE,TIMER_CFG_A_PERIODIC_UP);		
	TimerLoadSet(TIMERA0_BASE,TIMER_BOTH,80000000);				
	TimerPrescaleSet(TIMERA0_BASE,TIMER_A,0x00);			
	TimerIntEnable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);		
	TimerIntRegister(TIMERA0_BASE,TIMER_BOTH,&RTC_INT);	
	TimerEnable(TIMERA0_BASE,TIMER_BOTH);						
}


void INT_1(void)       											
{
	GPIOIntDisable(GPIOA1_BASE,GPIO_INT_PIN_6);
	GPIOIntClear(GPIOA1_BASE,GPIO_INT_PIN_6);					
	double volt=0;
	int queue_len=0;
	switch(task_flag)
	{
		case 1:													
			TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			queue_len=queue1_length;
			while(queue1_length>0)
			{
				queue1_length--;
				volt=volt+pow(volt_sample[queue1_length],2);
			}
			queue1_length=0;
			volt=sqrt(volt/queue_len);
			volt=volt*15.7*(230/9);
			if(volt>200 && volt<350)
				rms_volt=volt;
			rms_v[queue_length1]=rms_volt;
			queue_length1++;
			break;
		case 2:													
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
		case 3:													
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
			}
			break;
	}
	k++;
	GPIOIntEnable(GPIOA1_BASE,GPIO_INT_PIN_6);
}



void INT_2(void)       										 	
{
	GPIOIntDisable(GPIOA3_BASE,GPIO_INT_PIN_4);
	GPIOIntClear(GPIOA3_BASE,GPIO_INT_PIN_4);					
	int queue_len=0;
	double curr=0;
	switch(task_flag)
	{
		case 1:													
			queue_len=queue2_length;
			while(queue2_length>0)
			{
				queue2_length--;
				curr=curr+pow(curr_sample[queue2_length],2);
			}
			queue2_length=0;
			curr=sqrt(curr/queue_len);
			rms_curr=(curr*2-1.5)*10;
			rms_c[queue_length2]=rms_curr;
			queue_length2++;
			break;
		case 2:													
			break;
		case 3:													
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
				phase_flag=0;
			}
			break;
		case 4:
			TimerIntDisable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
			if(queue_length1>0)
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
			}
			break;
	}
	delayMicroseconds(100);
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);
	j++;
}

void INT_init(void)												
{
	GPIOIntTypeSet(GPIOA1_BASE,GPIO_INT_PIN_6,GPIO_RISING_EDGE); 
	GPIOIntTypeSet(GPIOA3_BASE,GPIO_INT_PIN_4,GPIO_RISING_EDGE); 
	GPIOIntRegister(GPIOA1_BASE,&INT_1);   						
	GPIOIntRegister(GPIOA3_BASE,&INT_2);   						
	GPIOIntEnable(GPIOA1_BASE,GPIO_INT_PIN_6);   				
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);					
	IntEnable(FAULT_SYSTICK);
}

void SAMPLE_INT(void)
{
	TimerIntClear(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	









}

void SAMPLE_init(void)
{
	TimerDisable(TIMERA1_BASE,TIMER_A);						
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_SPLIT_PAIR);		
	TimerConfigure(TIMERA1_BASE,TIMER_CFG_A_PERIODIC_UP);	
	TimerLoadSet(TIMERA1_BASE,TIMER_A,4000);				
	TimerPrescaleSet(TIMERA1_BASE,TIMER_A,0x00);			
	TimerIntRegister(TIMERA1_BASE,TIMER_A,&SAMPLE_INT);		
	TimerEnable(TIMERA1_BASE,TIMER_A);
}

void printWifiStatus() {
  
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}



void setup()
{
	IntMasterDisable();
	IntVTableBaseSet((unsigned long)&g_pfnVectors[0]);
	PinMuxConfig();												
	ADC_init();
	SAMPLE_init();
	INT_init();
	RTC_init();
	TimerIntEnable(TIMERA1_BASE,TIMER_TIMA_TIMEOUT);
	IntMasterEnable();
	WiFi.begin(ssid,password);
	Serial.begin(9600);
}
void loop()
{
	a=ADC_1();
	b=ADC_2();
}



