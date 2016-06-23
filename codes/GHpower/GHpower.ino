
volatile unsigned int time1=0;
volatile unsigned int time2=0;
double frequency=0,rms_volt=0,rms_volt_pre1,rms_volt_pre2=0;
int rms_volt_avg[20]={0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0};
int indexx=0;
int queue_length=0,que_length=0;
volatile unsigned int count_check=0,count=0;
int on,i=0;





struct queue
{
  double voltage;
  struct queue *next;
  struct queue *prev;
}*front=NULL,*endd=NULL;

void enqueue(double volt)
{
     if(front==NULL)
      {
        front=(struct queue*)malloc(sizeof(struct queue));
        front->voltage=volt;
        front->next=NULL;
        front->prev=NULL;
        endd=front;
      }
      else
      {
        struct queue *newnode;
        newnode=(struct queue*)malloc(sizeof(struct queue));
        newnode->voltage=volt;
        endd->next=newnode;
        newnode->prev=endd;
        newnode->next=NULL;
        endd=newnode;
      }
      queue_length++;
}

void dequeue(void)
{
  if(queue_length!=0)
  {
    struct queue *newnode;
    newnode=endd;
    endd=endd->prev;
    endd->next=NULL;
    free(newnode);
    queue_length--;
  }
  else
  return;
}

void setup()
{
Serial.begin(9600);
}

void loop()
{
  if(on==1)
  {
    Serial.print("Frequency is:");
    Serial.println(frequency,DEC);
    Serial.print("Voltage is:");
    Serial.println((rms_volt+rms_volt_pre1+rms_volt_pre2)/3,DEC);
  } 
  else
  {
    Serial.println("Switched off");
  }
  delay(1000);
}


