# Laravel Has Uuid For Laravel

## 📌 Sobre o Projeto
O **Laravel Has Uuid** é um package para Laravel que fornece autenticação via API (usando Laravel Sanctum) e gerenciamento de planos com limites de requisições.

## ✨ Funcionalidades
- 🔄 **Trait Uuid** usando a trait você consegue ter uma implementação automatica de uuid no lugar do int

---

## 🚀 Instalação

### 1️⃣ Requisitos
Antes de instalar, certifique-se de que seu projeto atenda aos seguintes requisitos:
- PHP >= 8.0
- Laravel >= 10
- Composer instalado

### 2️⃣ Instalação do Package
Execute o seguinte comando no terminal:
```bash
  composer require risetechapps/has-uuid-for-laravel
```

### 3️⃣ Configure seu Model
```bash
  use RiseTechApps\HasUuid\Traits\HasUuid\HasUuid;
  
class Client extends Model
{
    use HasFactory, HasUuid;
}
```
---

## 🛠 Contribuição
Sinta-se à vontade para contribuir! Basta seguir estes passos:
1. Faça um fork do repositório
2. Crie uma branch (`feature/nova-funcionalidade`)
3. Faça um commit das suas alterações
4. Envie um Pull Request

---

## 📜 Licença
Este projeto é distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

💡 **Desenvolvido por [Rise Tech](https://risetech.com.br)**

