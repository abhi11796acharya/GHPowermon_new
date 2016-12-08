
![e-Yantra Summer Internship](http://www.e-yantra.org/img/EyantraLogoLarge.png)
![logo](https://www.civil.iitb.ac.in/~eldho/user/image/iitlogo-small.png)

***
# eYSIP-2016-Greenhouse Power Monitoring and Appliance Control

With this project we aim to make a "smart" device which is able to monitor electrical consumptions of various appliances(exhaust fan,fogger, water pump etc), inform the user about consumption and provide options for scheduling turn on/off time of appliance. The system will consist of a wi-fi enabled device which measure and display power consumption of an appliance. Device will be capable of turning on/off the device from web, scheduling the on/off time of the device. 

Wi-Fi Enabled Device is created using the Following Hardware and Software Tools.
* **Microcontroller Board** CC3200 Wi-Fi Launchpad
* **Software Used**  Code Composer Studio v6.1.3,Energia, Cool-term , Tera Term

Website is designed using the following Web development technologies:
* **Front-end+Back-end:**  HTML,PHP,CSS, Javascript (including JQuery and AJAX)
* **Database:** MySQL
* **Communication Protocol:** HTTP
* **Web Tools:** Notepad ++ Text editor
* **Development platform:** Windows
* **Target Environment:** Desktop

##Features:
*** 
* The system consists of a Wi-Fi enabled device which can measure and upload data on Web servers.
* It is the industry’s first on chip Wi-Fi microcontroller unit “CC3200”.
* Device is able to measure voltage, current, frequency and phase of electrical signals with high accuracy: 
 + Voltage sensitivity of the device is 0.093V.
 + Current sensitivity of the device is 0.0055A.
 + Error in frequency measurement is 3%.
* Number of ADC channels on the device restricts it to monitor only three connected electrical sockets but web based controlling feature can be extended to 20 more sockets.
* The web GUI allows user to monitor live data with real-time updating graphs, which can plot electrical parameters of 3 devices simultaneously.
* The data uploaded by the Wi-Fi enabled device is continuously logged in database and can be viewed as static graphs with options to choose the intervals.
* The GUI can also generate log in .csv file format for both selected interval and complete log.
* GUI also allows remote controlling of the connected devices with features like : 
  + 1.	Switching ON/OFF with power button.
  + 2.	Scheduling ON/OFF.
* A feedback system is also present to check and compare current Button status and actual Device status as sent by the Wi-Fi enabled device.
* The device has a terminal based interactive GUI to configure the Wi-Fi & server setting of device without looking into the code.

##Folder Tree
###Documentation
 *Documents* Folder contains the detailed report, Progress presentation and documentation files for CC3200 Wi-Fi launch pad
###Observations
 *Observations* Folder contains all the observed data during testing of the device, which also includes waveforms observed on DSO.
###PCB and schematic
 *PCB and schematic* Folder contains PCB design file and schematic.
###Softwares and Codes
 *Softwares and Codes* Folder contains complete codes with all versions and test files included.It is further divided into web codes  and device codes.
   * Device Codes : Consists of all codes related to Wi-Fi enabled *"Smart Switchboard"*.
   * Web codes : Consists of Web GUI related codes.

##Contributors
***
  * [Avilash Mohanty](https://github.com/Avilashm)
  * [Abhishek Acharya](https://github.com/abhi11796acharya)
  
## Mentors
***
  * [Saurav Shandilya](https://github.com/sauravshandilya)
  * [Vishwanathan Iyer](https://github.com/vishwanathan-iyer)



##License
***
This project is open-sourced under [MIT License](http://opensource.org/licenses/MIT)
