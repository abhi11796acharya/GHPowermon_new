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


#include "commonheader.h"
#include "stdlib.h"
extern void (* const g_pfnVectors[])(void); //declaration of the Interrupt vector table {extern because it has been already declared in startup_ccs.c}
volatile double rms_volt=0,rms_curr=0,l;
volatile unsigned long queue_length1=0,queue_length2=0;
volatile unsigned long j,k,i;
volatile double volt_samples[500],curr_samples[500];

 	 	 	 	 	 	 	 	 	/**************GLOBLE FUNCTIONS*************/
void Timer_init(void);

void INT_1(void)       											//Interrupt handler for interrupts at GPIOA1
{
	double volt=0;
	int queue_len=0;
	queue_len=queue_length1;
	while(queue_length1>0)
	{
		queue_length1--;
		volt=volt+pow(volt_samples[queue_length1],2);
	}
	queue_length1=0;
	volt=sqrt(volt/queue_len);
	rms_volt=((volt-0.18)*22*(241.5/9.47));
	i++;
	GPIOIntClear(GPIOA1_BASE,GPIO_INT_PIN_6);					//Nessasary to clear the interrupt(EDGE) other wise program will execute interrupt fuction only
}



void INT_2(void)       										 	//Interrupt handler for interrupts at GPIOA3
{
	int volt=0,queue_len=0;
	queue_len=queue_length2;
	while(queue_length2>0)
	{
		queue_length2--;
		volt=volt+pow(volt_samples[queue_length2],2);
	}
	queue_length2=0;
	volt=sqrt(volt/queue_len);
	rms_volt=(volt*volt_calibration);
	i++;
	GPIOIntClear(GPIOA3_BASE,GPIO_INT_PIN_4);					//Nessasary to clear the interrupt(EDGE) other wise program will execute interrupt fuction only
}



void INT_init(void)												//Interrupt configuration fuction
{
	IntMasterDisable();         								//disables all globle interrupts before configuring
	GPIOIntTypeSet(GPIOA1_BASE,GPIO_INT_PIN_6,GPIO_RISING_EDGE); //Interrupt configuration at pin05(GPIO14) for Frequency calculation
	GPIOIntTypeSet(GPIOA3_BASE,GPIO_INT_PIN_4,GPIO_RISING_EDGE); //Interrupt configuration at pin18(GPIO28) for Phase calculation
	IntVTableBaseSet((unsigned long)&g_pfnVectors[0]);  		//Setting up the base of vector table
	GPIOIntRegister(GPIOA1_BASE,&INT_1);   						//Registering the interrupt handler for Interrupts at port GPIOA1
	GPIOIntRegister(GPIOA3_BASE,&INT_2);   						//Registering the interrupt handler for Interrupts at port GPIOA3
	GPIOIntEnable(GPIOA1_BASE,GPIO_INT_PIN_6);   				//Enables the external interrupt at pin05(GPIO14)
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);					//Enables the external interrupt at pin18(GPIO28)
	IntMasterEnable();											//Enables the globle interrupts again
}



void ADC_init(void)
{
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_2)!=0)						//flush the FIFO registers of ADC_CH_1 and
		ADCFIFORead(ADC_BASE,ADC_CH_2);							//ADC_CH_2 if it is not empty
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_1)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_1);
	ADCTimerConfig(ADC_BASE,2^17);								//configures ADC_Timer with 2^17 resolution
	ADCEnable(ADC_BASE);										//Enables gloable ADC
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


void TIMER0A_INT(void)
{
	volt_samples[queue_length1]=ADC_1();
	//curr_samples[queue_length2]=ADC_2();
	volt_samples[queue_length1]=((volt_samples[queue_length1]/4096)*1.467);
	//curr_samples[queue_length2]=((curr_samples[queue_length2]/4096)*1.5);
	queue_length1++;
	//queue_length2++;
	j++;
	TimerIntClear(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);						//clears the interrupt
}



void Timer_init(void)
{
	IntMasterDisable();										//Disables global interrupt before configuring
	TimerDisable(TIMERA0_BASE,TIMER_BOTH);					//Disables timer before configuring
	TimerConfigure(TIMERA0_BASE,TIMER_CFG_SPLIT_PAIR);		//configures timer0 as split mode
	TimerConfigure(TIMERA0_BASE,TIMER_CFG_A_PERIODIC_UP);	//configures timerA of timer0 as periodic up counter
	TimerLoadSet(TIMERA0_BASE,TIMER_A,4000);				//loading 4000 as the top value of timerA(Timer0)
	TimerPrescaleSet(TIMERA0_BASE,TIMER_A,0x00);			//clock frequency of timer is configured as (80Mhz/prescale)
	TimerIntEnable(TIMERA0_BASE,TIMER_TIMA_TIMEOUT);		//Timeout interrupt is enabled for TimerA(Timer0)
	TimerIntRegister(TIMERA0_BASE,TIMER_A,&TIMER0A_INT);	//Interrupt handler is registered for TimerA(Timer0)
	TimerEnable(TIMERA0_BASE,TIMER_A);						//TimerA of Timer0 has been enabled
	IntMasterEnable();										//Enables global interrupt
}






void main()
{
	k=k+1;
	PinMuxConfig();												//Pin mux setting for the project
	k=k+1;
	INT_init();
	k=k+1;
	ADC_init();
	k=k+1;
	Timer_init();
	while(1)
	{
		l=ADC_1();
	}
}
