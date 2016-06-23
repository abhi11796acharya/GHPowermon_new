void setupon_off()
{
}

void loopon_off()
{
  count=count_check;
  delay(30);
  if(count==count_check)
  {
    on=0;
    while(queue_length!=0)
    dequeue();
  }
  else
  on=1;
}
  
  
