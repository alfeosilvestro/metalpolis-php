### Step 1
docker login 
username: alfeosilvestro

### Step 2
docker build -t metalpolis .


### Step 3
docker run -p 8080:80 -d metalpolis
