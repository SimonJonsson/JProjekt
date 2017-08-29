import csv
import sys
import pymysql

db = pymysql.connect(host='localhost',port=3306,user='root', passwd='root', db='jproj',  use_unicode=True, charset="utf8")

cursor = db.cursor()

sql = "SELECT word FROM persianwords"
cursor.execute(sql)
wordlist = []
duplic = 0

for row in cursor:
    #sys.stdout.buffer.write(row[0].encode("utf-8"))
    if (wordlist.count(row[0]) > 0):
        duplic = duplic + 1
    else:
        wordlist.append(row[0])

print(duplic)
