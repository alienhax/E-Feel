#!/usr/bin/python
'''
procedural file for creating automated listing videos

author: David Cruz
'''

import datetime
import glob
from PIL import Image
import locale
import math
import MySQLdb
import os
import re
import requests
import shutil
import smtplib
import string
import struct
import subprocess
import sys

locale.setlocale( locale.LC_ALL, '' )

class UnknownImageFormat(Exception):
    pass

def get_image_size(file_path):
    """
    Return (width, height) for a given img file content - no external
    dependencies except the os and struct modules from core
    """
    size = os.path.getsize(file_path)

    with open(file_path) as input:
        height = -1
        width = -1
        data = input.read(25)

        if (size >= 10) and data[:6] in ('GIF87a', 'GIF89a'):
            # GIFs
            w, h = struct.unpack("<HH", data[6:10])
            width = int(w)
            height = int(h)
        elif ((size >= 24) and data.startswith('\211PNG\r\n\032\n')
              and (data[12:16] == 'IHDR')):
            # PNGs
            w, h = struct.unpack(">LL", data[16:24])
            width = int(w)
            height = int(h)
        elif (size >= 16) and data.startswith('\211PNG\r\n\032\n'):
            # older PNGs?
            w, h = struct.unpack(">LL", data[8:16])
            width = int(w)
            height = int(h)
        elif (size >= 2) and data.startswith('\377\330'):
            # JPEG
            msg = " raised while trying to decode as JPEG."
            input.seek(0)
            input.read(2)
            b = input.read(1)
            try:
                while (b and ord(b) != 0xDA):
                    while (ord(b) != 0xFF): b = input.read(1)
                    while (ord(b) == 0xFF): b = input.read(1)
                    if (ord(b) >= 0xC0 and ord(b) <= 0xC3):
                        input.read(3)
                        h, w = struct.unpack(">HH", input.read(4))
                        break
                    else:
                        input.read(int(struct.unpack(">H", input.read(2))[0])-2)
                    b = input.read(1)
                width = int(w)
                height = int(h)
            except struct.error:
                #raise UnknownImageFormat("StructError" + msg)
            	width = 0
            	height = 0
            except ValueError:
                #raise UnknownImageFormat("ValueError" + msg)
            	width = 0
            	height = 0
            except Exception as e:
                #raise UnknownImageFormat(e.__class__.__name__ + msg)
        		width = 0
        		height = 0
        else:
			'''
			raise UnknownImageFormat(
				"Sorry, don't know how to get information from this file."
			)
			'''
			width = 0
			height = 0

    return width, height


def get_media_length(filename):
	result = subprocess.Popen(["ffprobe", filename],stdout = subprocess.PIPE, stderr = subprocess.STDOUT)
	return [x for x in result.stdout.readlines() if "Duration" in x]

try:
	str_dest_dir = '/home/alienhax/workspace/eMerge2015/uploaded_images'
	str_ffmpeg_1 = 'ffmpeg'
	str_ffmpeg_2 = ''
	str_ffmpeg_3 = ''
	str_ffmpeg_4 = ''
	str_ffmpeg_cmd = ''
	int_imgs = 0
	#get images from directory
	for str_file in glob.glob("/home/alienhax/workspace/eMerge2015/uploaded_images/*.jpg"):
		#build input file string
		str_ffmpeg_2 += " -loop 1 -i %s -loop 1 " % (str_file)
		#build vf string
		str_ffmpeg_3 += "[%s:v]trim=duration=5[v%s];" % (int_imgs,int_imgs)
		str_ffmpeg_4 += "[v%s]" % int_imgs
		int_imgs = int_imgs + 1
	#build filters if images collected
	os.system("""ffmpeg %s -filter_complex "%s%sconcat=n=%s:v=1:a=0,format=yuv422p[v]" -map "[v]" -target ntsc-dvd -pix_fmt yuv422p -y %s/concatenated.mpg""" % (str_ffmpeg_2,str_ffmpeg_3,str_ffmpeg_4,int_imgs, str_dest_dir))	
	
	#append music
	##os.system("ffmpeg -i %s/concatenated.mp4 -i %s/uploaded.mp3 -loop 1 %s -c:v copy -c:a aac -strict experimental -shortest %s/final.mp4" % (str_dest_dir,str_dest_dir,int_audio_loops,str_afade,str_dest_dir))
	os.system("""ffmpeg -i %s/concatenated.mpg -i %s/uploaded.mp3 -vcodec copy -acodec copy -acodec copy -shortest %s/final.mp4 """ % (str_dest_dir, str_dest_dir, str_dest_dir)) 
	os.system("""ffmpeg -i %s/concatenated.mpg -i %s/uploaded.mp3 -vcodec copy -acodec copy -acodec copy -shortest %s/final.mpg """ % (str_dest_dir, str_dest_dir, str_dest_dir)) 
	'''
	ffmpeg -i source.mkv -i conca.mp3 -vcodec copy -acodec copy -acodec copy destination.mkv
	'''

except Exception, e:
	exc_type, exc_obj, exc_tb = sys.exc_info()
	fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
	print(exc_type, fname, exc_tb.tb_lineno, str(sys.exc_info()))
	
finally:
	print 'cleaning up...'
	print '...done!'
