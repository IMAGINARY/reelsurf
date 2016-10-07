# reelsurf
Web interface for creating jQuery reel animations of algebraic surfaces

Installation without docker is best understood by consulting the [`Dockerfile`](Dockerfile).

Currently, only Alpine linux is fully supported, but the scripts may work on
almost any Linux distribution with minor adjustments.

## Build
```
docker build -t reelsurf .
```

## Run
```
docker run -d --name reelsurf -p 8080:80 reelsurf
```
## Stopping
```
docker stop reelsurf && docker rm reelsurf
```

## License
This project is licensed under the [Apache v2 license](LICENSE).
