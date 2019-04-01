# -*- coding = UTF-8 -*-
from steering import Steering
import time
import configparser
import sys


class Camera:
    def __init__(self):
        '''
        Read config file to init camera's parameter
        '''
        config = configparser.ConfigParser()
        config.read("config.ini")
        self.statu=""
        # Horiazonal direction control parameters
        HIntfNum = config.getint("camera", "HIntfNum")
        HInitPosition = config.getint("camera", "HInitPosition")
        HMinPosition = config.getint("camera", "HMinPosition")
        HMaxPosition = config.getint("camera", "HMaxPosition")
        HSpeed = config.getint("camera", "HSpeed")

        # Vertical direction control parameters
        VIntfNum = config.getint("camera", "VIntfNum")
        VInitPosition = config.getint("camera", "VInitPosition")
        VMinPosition = config.getint("camera", "VMinPosition")
        VMaxPosition = config.getint("camera", "VMaxPosition")
        VSpeed = config.getint("camera", "VSpeed")

        self.HCameraControl = Steering(
            HIntfNum, HInitPosition, HMinPosition, HMaxPosition, HSpeed)
        self.VCameraControl = Steering(
            VIntfNum, VInitPosition, VMinPosition, VMaxPosition, VSpeed)

    def cameraRotate(self, direction):
        '''
        This method is used to contorl the camera's rotating
        The value of parameter direction and its meaning as follow:
        HR - Turn right
        HL - Turn left
        VU - Turn upward
        VD - Turn downword
        '''
        if direction == "HL":
            self.HCameraControl.forwardRotation()
            config = configparser.ConfigParser()
            config.read("config.ini")
            H = self.HCameraControl.position
            config.set("camera", "HInitPosition", str(H))
            with open("config.ini", "w+") as f:
                config.write(f)
            self.statu="LEFT"
        elif direction == "HR":
            self.HCameraControl.reverseRotation()
            config = configparser.ConfigParser()
            config.read("config.ini")
            H = self.HCameraControl.position
            config.set("camera", "HInitPosition", str(H))
            with open("config.ini", "w+") as f:
                config.write(f)
            self.statu = "RIGHT"
        elif direction == "VU":
            self.VCameraControl.forwardRotation()
            config = configparser.ConfigParser()
            config.read("config.ini")
            V = self.VCameraControl.position
            config.set("camera", "VInitPosition", str(V))
            with open("config.ini", "w+") as f:
                config.write(f)
            self.statu = "UP"
        elif direction == "VD":
            self.VCameraControl.reverseRotation()
            config = configparser.ConfigParser()
            config.read("config.ini")
            V = self.VCameraControl.position
            config.set("camera", "VInitPosition", str(V))
            with open("config.ini", "w+") as f:
                config.write(f)
            self.statu = "DOWN"
        elif direction == "RESET":
            self.HCameraControl.reset()
            self.VCameraControl.reset()
            config = configparser.ConfigParser()
            config.read("config.ini")
            H = 80
            V = 50
            config.set("camera", "HInitPosition", str(H))
            config.set("camera", "VInitPosition", str(V))
            with open("config.ini", "w+") as f:
                config.write(f)
            self.statu = "RESET"
        else:
            print(
                "Your input for camera direction is wrong, please input: HR, HL, VU, VD or RESET!")

    def __del__(self):
        print(self.statu+" over and "+"camera has been deleted")


if __name__ == "__main__":
    camera = Camera()
    direction = sys.argv[1]
    camera.cameraRotate(direction)
