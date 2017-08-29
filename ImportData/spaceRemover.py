import sys
import pymysql

db = pymysql.connect(host='localhost',port=3306,user='root', passwd='root', db='jproj',  use_unicode=True, charset="utf8")
#db = pymysql.connect(host='textmine.se.mysql',port=3306,user='textmine_se', passwd='Y5NZ28CJ', db='textmine_se',  use_unicode=True, charset="utf8")
cursor = db.cursor()

sql = "SELECT * FROM persianwords WHERE source='ordbook5000'"
cursor.execute(sql)
count = 0
cursorU = db.cursor()
for row in cursor:
    word = row[1]
    if (word[0] == " "):
        count = count + 1
        sqlU = "UPDATE persianwords SET word='" + word[1:] + "' WHERE id=" + str(row[0])
        #stri = word[0:len(word)-1] + " " + word + "\n"
        #sys.stdout.buffer.write(stri.encode("utf-8")) # For debugging persian characters
        cursorU.execute(sqlU)

        db.commit()
db.close()
print(count)
