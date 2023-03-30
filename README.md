# Mosquitto on Docker Container

This repo provides sample configurations for eclipse-mosquitto on docker with
following settings:

* No Encryption + No Authentication

# Notes

* It works with both `podman` and `docker` (need sudo).
* `:Z` suffix in the path was added for SELinux labeling.

# Directories and Files

* `/cleartext` : No encryption, no client authentication

Each directory contains

* `server.sh`: run server with docker
* `docker-compose.yml`: run server with docker-compose
* `mqtt_pub.sh`: mosquitto client for a publisher role
* `mqtt_sub.sh`: mosquitto client for a subscriber role
* `publish.py`: python client for a publisher role
* `subscribe.py`: python client for a subscriber role
* `publish.php`: php client for a publisher role
* `subscribe.php`: php client for a subscriber role
* `mount/mosquitto.conf`: configuration file mounted to the container

Following files are used when applicable

* `mount/certs`: server certificates

# Prerequisites

## eclipse-mosquitto docker image
```
docker pull eclipse-mosquitto:latest
```

## eclipse-mosquitto clients

* Debian based
```
sudo apt install mosquitto-clients
```

* Redhat based (**Be sure to disable the bare-metal mosquitto server!!**)
```
sudo dnf install mosquitto
sudo systemctl disable mosquitto.service
```


## Python paho-mqtt client
```
pip3 install paho-mqtt
```

# Testing

* Run the server as a daemon (docker users may need sudo)
```
./server.sh
```

* Listen to the topic at the background
```
./subscribe.py &
```

* Publish data to the topic
```
./publish.py
```

* Kill the background process
```
ps
kill -9 <process no>
```

* Shutdown the server daemon
```
docker container stop mosquitto
```

