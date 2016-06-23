volatile unsigned int time1=0;
volatile unsigned int time2=0;
double frequency=0;
double freq=0;

void setup()
{

  pinMode(GREEN_LED, OUTPUT);
  Serial.begin(9600);

  /* Enable internal pullup. 
   * Without the pin will float and the example will not work */
  pinMode(PUSH2, INPUT_PULLUP);
  attachInterrupt(PUSH2, frequency_loop, RISING); // Interrupt is fired whenever button is pressed
}

void loop()
{ 
  frequency=(1/(time2*0.000001));
   Serial.println(frequency,DEC);
   Serial.print("\n");
   delay(100);
}

void frequency_loop()
{
  time2=(micros()-time1);
  time1=micros();
}
