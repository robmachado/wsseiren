# ORDEM DE DESLIGAMENTO

## 1. Desligar NAS

> IP: 192.168.0.9:8000

> user: admin

> password: monitor5 

> No menu superior direito "A" dentro de um circulo, cliquen em desligar

## 2. Desligar servidor VMWare com o server virtual w2k (base de dados legado)

> IP: 192.168.0.4\
> Essa é uma das maquinas IBM do RACK, com o VMWare. 

> user: root

> password: q1w2e3r4

> No menu esquerdo, clique em "More VMs"\
> Com isso no menu direito aparecerão todos as VMs instaladas (ativas ou INATIVAS)\
 
> #### Usando o acesso remoto do windows, acesse a VM com o IP 192.168.0.5, e como administrador (senha: ferDALfima), desligue a maquina.
 
> Observe o desligamento dessa maquina windows pelo browser (VMWare), verifique se mais alguma VM está ativa nessa maquina VMWare, se estiver e for linux, pode acessar pelo IP indicado no menu ao clicar sobre o nome da VM.
> ou clicando na miniatura de tela da VM irá abrir uma sessão com o console do linux.
 
> Todas as maquinas virtuais linux do parque de servidores tem o mesmo USER e PASSWORD.

> USER: root

> PASSWORD: monitor5

> O comando de console para o desligamento de maquinas linux é :\
> **shutdown -h now**

> Assim que todas as maquinas virtuais forem desligadas, o servidor VMWare pode ser desligado.\
> **Para isso, clique sobre o menu esquerdo "Host", isso irá alterar o menu direito e poderá desligar o VMWare clicando em "Shut Down".**

> Aguarde o desligamento completo do servidor VMWare, assim que desligar o led verde do painel do servidor ficará "PISCANTE".  

## 3. Desligar servidor VMWare com demais maquinas da rede 
> IP: 192.168.0.4\
> Essa é uma das maquinas IBM do RACK, com o VMWare.

> user: root

> password: q1w2e3r4

> No menu esquerdo, clique em "More VMs"\
> Com isso no menu direito aparecerão todos as VMs instaladas (ativas ou INATIVAS)\
 
> Este servidor VMWare, possui as sequintes maquinas virtuais que devem ser desligadas:

> - titan    IP: 192.168.0.12 user:root pass:monitor5
 
> - kosten   IP: 192.168.0.14 user:root pass:monitor5

> - evol     IP: 192.168.0.21 user:root pass:monitor5 

> - seiren   IP: 192.168.0.23 user:root pass:monitor5

> - mysqldb  IP: normalmente desligada pode clicar em ShutDown no menu superior se ela estiver ligada 

> - cnpj     IP: normalmente desligada pode clicar em ShutDown no menu superior se ela estiver ligada

> - serverad IP: 192.168.0.222 user:root pass:monitor5

> As maquina linux podem ser desligadas usando PUTTY (pelo windows) ou pelo comando ssh de console do linux.

> **ssh root@informe_o_ip_da_maquina_linux**

> Ao aparecer o prompt de comando pedindo a senha, digite a senha.

> Caso a senha seja aceita, digite no prompt de comando: **shutdown -h now**
 
> Monitore o desligamento pelo browser (VMWare).
 
> Assim que todas as maquinas virtuais forem desligadas, o servidor VMWare pode ser desligado.\
> **Para isso, clique sobre o menu esquerdo "Host", isso irá alterar o menu direito e poderá desligar o VMWare clicando em "Shut Down".**

## 4. Desligue o servidor do RACK TORRE  
> IP: 192.168.0.1\
> Essa é uma da maquina com linux e contem o DHCP da rede.

> user: root

> password: monitor5
 
> Acesse com o PUTTY (a partir do windows) ou pelo ssh a partir do console do linux.

> **ssh root@192.168.0.1**

> Ao aparecer o prompt de comando pedindo a senha, digite a senha. 

> Caso a senha seja aceita, digite no prompt de comando: **shutdown -h now** 
 
## 5. Desligue as duas outras maquinas da sala de servidores (ubuntu e windows)

> Logue na maquina UBUNTU, pela interface grafica do desktop. 

> user: Administrador\
> pass: monitor5
 
> No menu superior direito o ultimo icone é o desligamento, clique e seleione "Desligar". 

> Logue na maquina WINDOWS, pela interface grafica do desktop. 

> user: Administrator
> pass: @ferDALfima
 
> Você sabe como desligar a maquina windows !!
