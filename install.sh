while [ 1 ]
do
    sudo -v
    # Aufbau des Menüs
    CHOICE=$(
        whiptail --title "proof of education installer" --menu "" 16 100 9 \
        "1)" "Install" \
        "2)" "Start Server" \
        "3)" "Stop Server" \
        "4)" "Only Export Database" \
        "5)" "Programm beenden" 3>&2 2>&1 1>&3
    )
    # Zuordnung Funktionen zu Menüpunkten
    case $CHOICE in
        "1)")
            {
                # dependencies
                if [[ -x "$(command -v pacman)" ]]
                then
                    echo "10"
                    sudo pacman -Syu --noconfirm
                    echo "50"
                    sudo pacman -S --noconfirm docker docker-compose mariadb whiptail 2> /dev/null
                    echo "75"
                elif [[ -x "$(command -v dnf)" ]]
                then
                    echo "10"
                    sudo dnf -y upgrade --refresh
                    echo "50"
                    sudo dnf -y install docker docker-compose mariadb whiptail 2> /dev/null
                    echo "75"
                elif [[ -x "$(command -v apt-get)" ]]
                then
                    echo "10"
                    sudo apt-get -y update && sudo apt-get -y upgrade
                    echo "50"
                    sudo apt-get -y install docker.io docker-compose mariadb-server whiptail 2> /dev/null
                    echo "75"
                else
                    echo 'This Distro is not supported!'
                fi
                # start
                sudo -S systemctl start docker.service
                echo "80"
                sudo -S systemctl enable docker.service
                echo "85"
                sudo docker-compose up -d 2> /dev/null
                echo "100"
            } |whiptail --title "Installing proof of education" --gauge "Please wait while installing" 6 60 0
        ;;
        "2)")
            sudo docker-compose up -d
            sleep 5s
            mysql -h127.0.0.1 -uroot -proot -P3307 -D nachweis_db < ausbildungsnachweis.sql
            whiptail --title "Start Server" --msgbox "Server started" 8 78
        ;;
        "3)")
            if (whiptail --title "Stop Server" --yesno "Are you sure you want to stop the server?" 8 78); then
                whiptail --title "Stop Server" --msgbox "Server stopped"
                echo "Yes"
                mysqldump -h127.0.0.1 -uroot -proot -P3307 nachweis_db > ausbildungsnachweis.sql
                sudo docker-compose down -v
            else
                echo "No"
            fi
        ;;
        
        "4)")
            mysqldump -h127.0.0.1 -uroot -proot -P3307 > ausbildungsnachweis.sql
            whiptail --title "Export Database" --msgbox "Database was saved"
        ;;
        "5)")
            exit
        ;;
    esac
done
