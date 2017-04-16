## Enviar mensagem SMS pele provedor TotalVoice Telecom

Para enviar uma mensagem de SMS você precisará do **access_token** da sua conta na TotalVoice.

Exemplo:

```
$ export TOTALVOICE_ACCESS_TOKEN=2828abcdeks
$ ./bin/console 48991567278 "Minha mensagem SMS"
```
Onde o primeiro parametro do comando `./bin/console` é o numero de destino no formato **48991567278** e o segundo
parâmentro é a mensagem.