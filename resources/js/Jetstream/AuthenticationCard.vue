<template>
    <div class="container mx-auto   min-h-screen flex flex-col sm:justify-center items-center pt-6 overflow-hidden sm:pt-0" style="background-color: #FBFBFB;">
        <div class=" 2xl:max-w-md xl:max-w-sm mt-6 relative">
            <div class="absolute" style="background-color: #7367F0; opacity:0.04; width:260px; height: 260px; top:-11%; left:-18%; border-radius: 20px; z-index: 0;"></div>
            <div class="absolute" style="border: 2px solid #F4F3FF; opacity:0.6; width:186px; height: 186px; top:-15%; left:8%; border-radius: 20px; z-index: 0;"></div>
            <div class="absolute" style="background-color: #7367F0; opacity:0.04; width:260px; height: 260px; top:72%; right:-10%; border-radius: 20px; z-index: 0;"></div>
            <div class="absolute" style="border: 2px dashed #7367F0; opacity:0.13; width:330px; height: 330px; top:65.5%; right:-17.5%; border-radius: 20px; z-index: 0;"></div>

            <div class="w-full bg-ins-1 relative 2xl:px-8 lg:px-6  2xl:pt-16 lg:pt-10 2xl:pb-20 lg:pb-16" style="border-radius: 12px; box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06); width: 25.4rem;">
                <div class="flex items-center justify-center">
                    <slot name="logo" />
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
