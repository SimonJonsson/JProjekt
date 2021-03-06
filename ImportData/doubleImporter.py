# doubleImporter in the sense that we import both dabire and persian dictionaries
import csv
import sys
import pymysql

wordlist = []
tag = "ordbok"
db = pymysql.connect(host='localhost',port=3306,user='root', passwd='root', db='jproj',  use_unicode=True, charset="utf8")
#db = pymysql.connect(host='textmine.se.mysql',port=3306,user='textmine_se', passwd='Y5NZ28CJ', db='textmine_se',  use_unicode=True, charset="utf8")
cursor = db.cursor()

# Adds each database entry to wordlist
sql = "SELECT * FROM persianwords WHERE source <> 'ordbook5000'"
cursor.execute(sql)
for row in cursor:
    wordlist.append(row[1])

#exit()
# Adds each unique entry in dictionary to wordlist
count = 0
if False: # True if we want to check for uniqueness
    with open('db5000.csv',  newline='', encoding='utf-8') as csvfile:
        reader = csv.reader(csvfile, delimiter=',')
        for row in reader:
            # For each row, check if in wordList
            # not in word list -> add to wordlist and add to db
            # in word list -> ignore word
            #print(row)
            #sys.stdout.buffer.write(row[1].encode("utf-8")) # For debugging persian characters
            if (wordlist.count(row[1]) == 0):
                count = count + 1
                wordlist.append(row[1])
                #sql = "INSERT INTO persianwords (word, tag, source) VALUES (\"" + row[1] + "\",\"" + tag + "\",\"ordbook5000\")"
                #cursor.execute(sql)
    #db.commit()
print("Numbers of words added:" + str(count))
exit()
print("Added Persianwords")

# Finds db-entry of persian word and matches the dabire entry with correct id
with open('db5000.csv', newline='', encoding='utf-8') as csvfile:
    reader = csv.reader(csvfile, delimiter=',')
    for row in reader:
        sql = "SELECT * FROM persianwords WHERE word='" + row[1] + "'"
        cursor.execute(sql)

        for id in cursor: # Really weird that we need this here
            id = id[0]

        sql = "INSERT INTO words (wordid, dabire, code) VALUES (" + str(id) + ", '" + row[0] + "', 'JALALM')"
        cursor.execute(sql)

db.commit()
print("Finished")
db.close()
