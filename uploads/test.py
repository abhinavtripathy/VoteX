import time

import Adafruit

import math as math

print(BS)
counter = 0;
while True:
    x, y, z = accel.read()
    if counter == 0:
        prex = x
        prey = y
        pre z = z
        counter += 1
    else:
        cix = prex - x
        ciy = prey - y
        ciz = prez - z
        if (math.fabs(cix) >= 100 or math.fabs(ciy) >= 100 or math.fabs(ciz)):
            print("Falling")
            prex = x
            prey = y
            prez = z
