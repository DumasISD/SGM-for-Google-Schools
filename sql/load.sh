
usage="usage: $0 <env> <file>"
if [ $# -ne 2 ]; then
  echo "error - bad usage"
  echo $usage
  exit 1
fi

env=$1
file=$2

if [ ! -f $file ]; then
	echo "error - file not found"
	exit 2
fi

. $HOME/dbauth.sh

Username="sgm"
Password="sgm"
Server="localhost"


if [ $env == "prod" ]; then
  Database="sgm";
  Server="127.0.0.1"
elif [ $env == "dev" ]; then
  Database="sgm_dev";
  Server="127.0.0.1"
else
  echo "error - bad db:  $env"
  exit 3
fi

mysql -p$Password -u $Username -h $Server $Database < $file

