. $HOME/dbauth.sh

usage="usage: $0 <env> ";
if [ $# -ne 1 ]; then
  echo "error - bad usage"
  echo $usage
  exit 2
fi

env=$1

Username="dumas"
Password="dumas"
Server="localhost"


if [ $env == "prod" ]; then
  Database="dumas";
  Server="127.0.0.1"
elif [ $env == "dev" ]; then
  Database="dumas_dev";
  Server="127.0.0.1"
else
  echo "error - bad db:  $env"
  exit 3
fi

mysqldump -p${Password} -u $Username --add-drop-table --skip-extended-insert $Database 


