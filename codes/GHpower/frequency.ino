void setupfreq()
{
  pinMode(PUSH2, INPUT_PULLUP);
}

void loopfreq()
{ 
  if(digitalRead(PUSH2)==HIGH)
  {
    time2=(micros()-time1);
    time1=micros();
    count_check++;
    que_length=queue_length;
    rms_volt_pre2=rms_volt_pre1;
    rms_volt_pre1=rms_volt;
    while(queue_length!=0)
    {
      rms_volt=rms_volt+pow(endd->voltage,2);
      dequeue();
    }
    rms_volt=(rms_volt/que_length)*2;
    rms_volt=sqrt(rms_volt);
    rms_volt=(rms_volt)*154.44;
    frequency= (1/(time2*0.000001));
  }
}

