import csv
import sys
import pymysql

wordlist = []
tag = "firstname"
db = pymysql.connect(host='localhost',port=3306,user='root', passwd='mysql', db='jproj',  use_unicode=True, charset="utf8")
#db = pymysql.connect(host='textmine.se.mysql',port=3306,user='textmine_se', passwd='Y5NZ28CJ', db='textmine_se',  use_unicode=True, charset="utf8")
cursor = db.cursor()

with open('names.csv',  newline='', encoding='utf-8') as csvfile:
    reader = csv.reader(csvfile, delimiter=',')
    for row in reader:
        # For each row, check if in wordList
        # not in word list -> add to wordlist and add to db
        # in word list -> ignore word
        if (wordlist.count(row[0]) > 0):
            print("not unique word")
        else:
            wordlist.append(row[0])
            sql = "INSERT INTO persianwords (word, tag) VALUES (\"" + row[0] + "\",\"" + tag + "\")"
            cursor.execute(sql)

db.commit()
db.close()
