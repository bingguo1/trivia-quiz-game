from pathlib import Path
import subprocess
import os
from datetime import datetime

input_dir="views/"
output_dir="."
backup_dir="backups"

postfix="*.ejs"
os.chdir("/var/www/trivia/trivia-quiz-game")

pathlist = Path(input_dir).glob(postfix)
timestring=datetime.now().strftime('%Y%m%d_%H%M%S')

for path in pathlist:
    ## npx ejs ./index.ejs -o output.html
    outputfilename=path.name.replace(postfix[1:],'.html')
    outputfullname=f"{output_dir}/{outputfilename}"
    print(f" {path} -----> {outputfullname}")
    if os.path.exists(outputfullname):
        backupfile=f"{backup_dir}/{outputfilename}_{timestring}"
        print(f"{outputfullname} already exists, move it to {backupfile}")
        subprocess.run(["mv", outputfullname, backupfile])
        
        
    
    subprocess.run(["npx", "ejs", str(path), "-o", outputfullname ])