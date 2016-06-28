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

#include "commonheader.h"
extern void (* const g_pfnVectors[])(void); //declaration of the Interrupt vector table {extern because it has been already declared in startup_ccs.c}
unsigned long k=0;



 	 	 	 	 	 	 	 	 	/**************GLOBLE FUNCTIONS*************/

void INT_1(void)       											//Interrupt handler for interrupts at GPIOA2
{
	GPIOPinWrite(GPIOA1_BASE,0x2,0x2);
}



void INT_2(void)       										 	//Interrupt handler for interrupts at GPIOA3
{

}



void INT_init(void)												//Interrupt configuration fuction
{
	IntMasterDisable();         								//diasables all globle interrupts before configuring
	GPIOIntTypeSet(GPIOA2_BASE,GPIO_INT_PIN_6,GPIO_HIGH_LEVEL); //Interrupt configuration at pin15(GPIO22) for Frequency calculation
	GPIOIntTypeSet(GPIOA3_BASE,GPIO_INT_PIN_4,GPIO_HIGH_LEVEL); //Interrupt configuration at pin18(GPIO28) for Phase calculation
	IntVTableBaseSet((unsigned long)&g_pfnVectors[0]);  		//Setting up the base of vector table
	GPIOIntRegister(GPIOA2_BASE,&INT_1);   						//Registering the interrupt handler for Interrupts at port GPIOA2
	GPIOIntRegister(GPIOA3_BASE,&INT_2);   						//Registering the interrupt handler for Interrupts at port GPIOA3
	GPIOIntEnable(GPIOA2_BASE,GPIO_INT_PIN_6);   				//Enables the external interrupt at pin15(GPIO22)
	GPIOIntEnable(GPIOA3_BASE,GPIO_INT_PIN_4);					//Enables the external interrupt at pin18(GPIO28)
	IntMasterEnable();											//Enables the globle interrupts again
}



void ADC_init(void)
{
	if(ADCFIFOLvlGet(ADC_BASE,ADC_CH_0)!=0)
		ADCFIFORead(ADC_BASE,ADC_CH_0);
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


int main()
{
	//PRCMCC3200MCUInit();										//mendatory clock genration for system
	PinMuxConfig();                                             //Pin mux setting for the project
	INT_init();
	ADC_init();
	while(1)
	{
		k=ADC_2();
	}
}
