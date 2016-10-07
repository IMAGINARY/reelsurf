#!/bin/bash/
SCRIPTPATH=`dirname "$0"`
cd "$SCRIPTPATH"
cd JavaScriptAnim

compression=$1
shift
outfile=$1
shift
java -cp "./bin:./lib/antlr-runtime-3.4.jar:./lib/commons-cli-1.2.jar:./lib/vecmath.jar" de.mfo.jsurfer.grid.RotationGrid $@ | convert - -quality $compression $outfile

