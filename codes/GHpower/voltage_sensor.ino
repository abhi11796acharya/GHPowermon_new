void setupvoltage()
{
  pinMode(A1,INPUT_PULLUP);
  analogReadResolution(12);
}

void loopvoltage()
{
    enqueue(((1.5/4096)*analogRead(A1)));
    delayMicroseconds(50);
}

