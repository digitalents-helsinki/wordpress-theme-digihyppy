#!/usr/bin/env bash


which -as yarn
if [ "$?" -ne 0 ]; then
  echo -e "${RED}Yarn not found. Exiting...${NC}"

fi

which -as npm
if [ "$?" -ne 0 ]; then
  echo -e "${RED}npm not found. Exiting...${NC}"
fi

which -as composer
if [ "$?" -ne 0 ]; then
  echo -e "${RED}Composer not found. Exiting...${NC}"
fi

which -as docker-compose
if [ "$?" -ne 0 ]; then
  echo -e "${RED}docker-compose not found. Exiting...${NC}"
fi