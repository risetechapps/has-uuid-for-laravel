# Laravel Has UUID for Laravel

## 📌 Sobre o projeto
O **Laravel Has UUID** é um pacote enxuto que adiciona uma única trait para gerar automaticamente chaves primárias do tipo UUID em modelos Eloquent. Ele é ideal para projetos que desejam substituir IDs auto incrementais por identificadores universais sem repetir código.

## ✨ Funcionalidades
- 🔄 **Geração automática de UUID**: atribui um UUID v4 sempre que um modelo é criado e ainda não possui um valor definido para a chave primária.
- 🔐 **Configuração adequada do modelo**: força o uso de chaves não incrementais e do tipo `string`, requisitos essenciais para trabalhar com UUIDs no Eloquent.

---

## 🚀 Instalação

### 1️⃣ Requisitos
Certifique-se de que seu projeto atende aos seguintes requisitos:
- PHP >= 8.1

### 2️⃣ Instalação do pacote
Execute o comando abaixo no terminal:

```bash
composer require risetechapps/has-uuid-for-laravel
```

### 3️⃣ Configure seu model
Adicione a trait `HasUuid` ao seu modelo Eloquent:

```php
use Illuminate\Database\Eloquent\Model;
use RiseTechApps\HasUuid\Traits\HasUuid;

class Client extends Model
{
    use HasUuid;
}
```

A trait irá preencher automaticamente a chave primária com um UUID caso você não defina um valor manualmente.

---

## 🛠 Contribuição
Sinta-se à vontade para contribuir! Basta seguir estes passos:
1. Faça um fork do repositório
2. Crie uma branch (`feature/minha-melhoria`)
3. Faça um commit das suas alterações
4. Envie um Pull Request

### 🧪 Executando os testes

```bash
composer install
composer test
```

---

## 📜 Licença
Este projeto é distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE.md) para mais detalhes.

---

💡 **Desenvolvido por [Rise Tech](https://risetech.com.br)**

