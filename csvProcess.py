import csv


pre="<span style=\"color:red;\">"
post="</span>"


i=1000
outFile = open("englishbycontextSheet1_organize.csv", "w")
outFile.write("number\t"+"category\t"+"question\t"+"answer\t"+"detail"+"\n")

with open('tablearnEnglishbycontextSheet1.tsv', newline = '\n') as myfile:
    records = csv.reader(myfile, delimiter='\t')

    for line in records:
        #        print(line)
        if(len(line)!=3):
    	    print("warning !!!!!!!!!!!!!!!!!!!!!!! length is not 3, but =", len(line))
        keywords=line[2].split(",");
        print()
        for keyword in keywords:
            # print(keyword, end=" ")
            if(keyword!=""):
                line[0]=line[0].replace(keyword, pre+keyword+post, 1)
        print(line[0])
        i=i+1
        outFile.write(str(i)+"\t95\t"+line[0]+"\t"+line[1]+"\t"+"\n")        

outFile.close()
