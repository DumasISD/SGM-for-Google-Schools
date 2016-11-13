usage="usage: $0 <env>"
if [ $# -ne 1 ]; then
  echo "error - bad usage"
  echo $usage
  exit 1
fi

env=$1


. $HOME/dbauth.sh

Server="localhost"

if [ $env == "prod" ]; then
  Database="sgm_prod";
  #Server="127.0.0.1"
elif [ $env == "dev" ]; then
  Database="sgm_dev";
  Server="127.0.0.1"
else
  echo "error - bad db:  $env"
  exit 3
fi

echo "mysql -p$Password -u $Username -h $Server $Database"

mysql -p$Password -u $Username -h $Server $Database
