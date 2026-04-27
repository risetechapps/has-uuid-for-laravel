# Changelog

All notable changes to `HasUuid` will be documented in this file

## [Unreleased]

### Added
- Adicionado suporte completo a testes unitários
- Criado `phpunit.xml` para configuração de testes
- Adicionados testes para validação de UUID, unicidade e ordenação
- **Novos métodos de busca**: `findByUuid()`, `findByUuidOrNull()` e `scopeByUuid()`
- Adicionado Laravel Pint para formatação de código
- Adicionado PHPStan (nível 8) para análise estática
- Novos comandos Composer: `format`, `format-check`, `analyse`

### Changed
- **CI/CD**: Atualizado workflow para PHP 8.3/8.4 e Laravel 12.x
- **CI/CD**: Atualizado para usar `actions/checkout@v4`
- **CI/CD**: Adicionados jobs de análise estática e verificação de código
- Removida versão hardcoded do `composer.json`
- Documentação atualizada com exemplo de migration e métodos de busca

## [1.1.0] - 2025-12-15

- Removido Proteção de updating do id na trait

## [1.0.0] - 2025-11-10

- Primeira versão lançada
