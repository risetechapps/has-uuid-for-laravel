# Laravel Has UUID for Laravel

## 📌 Sobre o projeto
O **Laravel Has UUID** é um pacote enxuto que adiciona uma única trait para gerar automaticamente chaves primárias do tipo UUID em modelos Eloquent. Ele é ideal para projetos que desejam substituir IDs auto incrementais por identificadores universais sem repetir código.

## ✨ Funcionalidades
- 🔄 **Geração automática de UUID**: atribui um UUID v4 ou v7 sempre que um modelo é criado e ainda não possui um valor definido para a chave primária.
- 🔐 **Configuração adequada do modelo**: força o uso de chaves não incrementais e do tipo `string`, requisitos essenciais para trabalhar com UUIDs no Eloquent.

---

## 🚀 Instalação

### 1️⃣ Requisitos
Certifique-se de que seu projeto atende aos seguintes requisitos:
- PHP >= 8.3
- Laravel 12.x
- Composer instalado

### 2️⃣ Instalação do pacote
Execute o comando abaixo no terminal:

```bash
  composer require risetechapps/has-uuid-for-laravel
```

### 3️⃣ Configure sua migration
Crie a migration com chave primária do tipo `string`:

```php
Schema::create('clients', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name');
    $table->timestamps();
});
```

### 4️⃣ Configure seu model
Adicione a trait `HasUuid` ao seu modelo Eloquent:

```php
use Illuminate\Database\Eloquent\Model;
use RiseTechApps\HasUuid\Traits\HasUuid;

class Client extends Model
{
    use HasUuid;

    protected $fillable = ['name'];
}
```

A trait irá preencher automaticamente a chave primária com um UUID caso você não defina um valor manualmente.

---

## 🔎 Métodos de Busca por UUID

A trait adiciona métodos convenientes para buscar modelos pelo UUID:

```php
// Busca por UUID - lança exceção se não encontrar
$client = Client::findByUuid('550e8400-e29b-41d4-a716-446655440000');

// Busca por UUID - retorna null se não encontrar
$client = Client::findByUuidOrNull('550e8400-e29b-41d4-a716-446655440000');

// Usando scope
$client = Client::byUuid('550e8400-e29b-41d4-a716-446655440000')->first();
```

---

## 🛠️ Comandos Disponíveis

| Comando | Descrição |
|---------|-----------|
| `composer test` | Executa os testes unitários |
| `composer test-coverage` | Executa testes com cobertura de código |
| `composer format` | Formata o código com Laravel Pint |
| `composer format-check` | Verifica se o código segue os padrões |
| `composer analyse` | Analisa o código com PHPStan (nível 8) |

---

## 🧪 Testes

Execute os testes do pacote:

```bash
composer test
```

Ou com cobertura de código:

```bash
composer test-coverage
```

---

## 🛠 Contribuição
Sinta-se à vontade para contribuir! Basta seguir estes passos:
1. Faça um fork do repositório
2. Crie uma branch (`feature/minha-melhoria`)
3. Faça um commit das suas alterações
4. Envie um Pull Request

---

## 📜 Licença
Este projeto é distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE.md) para mais detalhes.

---

💡 **Desenvolvido por [Rise Tech](https://risetech.com.br)**

