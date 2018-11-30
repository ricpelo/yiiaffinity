#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U yiiaffinity -d yiiaffinity < $BASE_DIR/yiiaffinity.sql
fi
psql -h localhost -U yiiaffinity -d yiiaffinity_test < $BASE_DIR/yiiaffinity.sql
