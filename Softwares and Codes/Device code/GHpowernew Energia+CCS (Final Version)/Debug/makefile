################################################################################
# Automatically-generated file. Do not edit!
################################################################################

SHELL = cmd.exe

CG_TOOL_ROOT := E:/GHpower/software/energia-0101E0017-windows/energia-0101E0017/hardware/tools/lm4f

GEN_OPTS__FLAG := 
GEN_CMDS__FLAG := 

ORDERED_OBJS += \
"./GHpowernew.o" \
$(GEN_CMDS__FLAG) \
-Wl,--start-group \
-Wl,-T"E:/GHpower/software/energia-0101E0017-windows/energia-0101E0017/hardware/cc3200/cores/cc3200/cc3200.ld" \
-llpcc3200_WiFi \
-llpcc3200_SPI \
-llpcc3200_core \
-ldriverlib \
-lm \
-lc \
-lgcc \
-Wl,--end-group \

-include ../makefile.init

RM := DEL /F
RMDIR := RMDIR /S/Q

# All of the sources participating in the build are defined here
-include sources.mk
-include subdir_vars.mk
-include subdir_rules.mk
-include objects.mk

ifneq ($(MAKECMDGOALS),clean)
ifneq ($(strip $(S_DEPS)),)
-include $(S_DEPS)
endif
ifneq ($(strip $(S_UPPER_DEPS)),)
-include $(S_UPPER_DEPS)
endif
ifneq ($(strip $(S62_DEPS)),)
-include $(S62_DEPS)
endif
ifneq ($(strip $(C64_DEPS)),)
-include $(C64_DEPS)
endif
ifneq ($(strip $(ASM_DEPS)),)
-include $(ASM_DEPS)
endif
ifneq ($(strip $(CC_DEPS)),)
-include $(CC_DEPS)
endif
ifneq ($(strip $(SV7A_DEPS)),)
-include $(SV7A_DEPS)
endif
ifneq ($(strip $(S55_DEPS)),)
-include $(S55_DEPS)
endif
ifneq ($(strip $(C67_DEPS)),)
-include $(C67_DEPS)
endif
ifneq ($(strip $(CLA_DEPS)),)
-include $(CLA_DEPS)
endif
ifneq ($(strip $(C??_DEPS)),)
-include $(C??_DEPS)
endif
ifneq ($(strip $(CPP_DEPS)),)
-include $(CPP_DEPS)
endif
ifneq ($(strip $(S??_DEPS)),)
-include $(S??_DEPS)
endif
ifneq ($(strip $(C_DEPS)),)
-include $(C_DEPS)
endif
ifneq ($(strip $(C62_DEPS)),)
-include $(C62_DEPS)
endif
ifneq ($(strip $(CXX_DEPS)),)
-include $(CXX_DEPS)
endif
ifneq ($(strip $(C++_DEPS)),)
-include $(C++_DEPS)
endif
ifneq ($(strip $(ASM_UPPER_DEPS)),)
-include $(ASM_UPPER_DEPS)
endif
ifneq ($(strip $(K_DEPS)),)
-include $(K_DEPS)
endif
ifneq ($(strip $(C43_DEPS)),)
-include $(C43_DEPS)
endif
ifneq ($(strip $(INO_DEPS)),)
-include $(INO_DEPS)
endif
ifneq ($(strip $(S67_DEPS)),)
-include $(S67_DEPS)
endif
ifneq ($(strip $(SA_DEPS)),)
-include $(SA_DEPS)
endif
ifneq ($(strip $(S43_DEPS)),)
-include $(S43_DEPS)
endif
ifneq ($(strip $(OPT_DEPS)),)
-include $(OPT_DEPS)
endif
ifneq ($(strip $(PDE_DEPS)),)
-include $(PDE_DEPS)
endif
ifneq ($(strip $(S64_DEPS)),)
-include $(S64_DEPS)
endif
ifneq ($(strip $(C_UPPER_DEPS)),)
-include $(C_UPPER_DEPS)
endif
ifneq ($(strip $(C55_DEPS)),)
-include $(C55_DEPS)
endif
endif

-include ../makefile.defs

# Add inputs and outputs from these tool invocations to the build variables 
EXE_OUTPUTS += \
GHpowernew.out \

EXE_OUTPUTS__QUOTED += \
"GHpowernew.out" \

BIN_OUTPUTS += \
GHpowernew.bin \

BIN_OUTPUTS__QUOTED += \
"GHpowernew.bin" \


# All Target
all: GHpowernew.out secondary-outputs

dependents:
	-cd E:/Texas\ instruments\ project-ccs/lpcc3200_core/Debug && $(MAKE) all
	-cd E:/Texas\ instruments\ project-ccs/lpcc3200_SPI/Debug && $(MAKE) all
	-cd E:/Texas\ instruments\ project-ccs/lpcc3200_WiFi/Debug && $(MAKE) all

# Tool invocations
GHpowernew.out: $(OBJS) $(A_SRCS) $(GEN_CMDS) E:/Texas\ instruments\ project-ccs/lpcc3200_core/Debug/liblpcc3200_core.a E:/Texas\ instruments\ project-ccs/lpcc3200_SPI/Debug/liblpcc3200_SPI.a E:/Texas\ instruments\ project-ccs/lpcc3200_WiFi/Debug/liblpcc3200_WiFi.a
	@echo 'Building target: $@'
	@echo 'Invoking: GNU Linker'
	"E:/GHpower/software/energia-0101E0017-windows/energia-0101E0017/hardware/tools/lm4f/bin/arm-none-eabi-gcc.exe" -march=armv7e-m -mthumb -fno-exceptions -DF_CPU=80000000L -DENERGIA=17 -DARDUINO=101 -Os -ffunction-sections -fdata-sections -g -gdwarf-3 -gstrict-dwarf -Wall --entry ResetISR -nostartfiles -nostdlib -Wl,--gc-sections -L"E:/Texas instruments project-ccs/lpcc3200_WiFi/Debug" -L"E:/Texas instruments project-ccs/lpcc3200_SPI/Debug" -L"E:/Texas instruments project-ccs/lpcc3200_core/Debug" -L"E:/GHpower/software/energia-0101E0017-windows/energia-0101E0017/hardware/cc3200/cores/cc3200/driverlib" -o"GHpowernew.out" $(ORDERED_OBJS) $(A_SRCS)
	@echo 'Finished building target: $@'
	@echo ' '

GHpowernew.bin: $(EXE_OUTPUTS)
	@echo 'Invoking: GNU Objcopy Utility'
	"E:/GHpower/software/energia-0101E0017-windows/energia-0101E0017/hardware/tools/lm4f/bin/arm-none-eabi-objcopy.exe" -O binary $(EXE_OUTPUTS__QUOTED) "GHpowernew.bin"
	@echo 'Finished building: $@'
	@echo ' '

# Other Targets
clean:
	-$(RM) $(EXE_OUTPUTS__QUOTED)$(BIN_OUTPUTS__QUOTED)
	-$(RM) "GHpowernew.d" 
	-$(RM) "GHpowernew.o" 
	-@echo 'Finished clean'
	-@echo ' '

secondary-outputs: $(BIN_OUTPUTS)

.PHONY: all clean dependents
.SECONDARY:
E:/Texas\ instruments\ project-ccs/lpcc3200_core/Debug/liblpcc3200_core.a:
E:/Texas\ instruments\ project-ccs/lpcc3200_SPI/Debug/liblpcc3200_SPI.a:
E:/Texas\ instruments\ project-ccs/lpcc3200_WiFi/Debug/liblpcc3200_WiFi.a:

-include ../makefile.targets

