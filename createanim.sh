#!/bin/bash/
CLASSPATH=$(find /usr/lib/jsurf/ -name "*.jar" | tr '\n' ':')

compression=$1
shift
outfile=$1
shift
java -cp "$CLASSPATH" de.mfo.jsurf.grid.RotationGrid $@ | convert - -quality $compression $outfile
