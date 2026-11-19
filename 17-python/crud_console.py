# ==============================================================
# CRUD_CONSOLE.PY - CRUD de produtos no terminal com banco SQLite
# Não precisa instalar nada além do Python (sqlite3 já vem junto).
# Rodar:  python crud_console.py
# Em Python, o que começa com # é comentário.
# ==============================================================
import sqlite3

# Conecta (cria o arquivo estoque.db se não existir)
conexao = sqlite3.connect("estoque.db")
conexao.row_factory = sqlite3.Row      # permite usar linha["nome"]
cursor = conexao.cursor()

cursor.execute("""
    CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        quantidade INTEGER NOT NULL DEFAULT 0,
        estoque_minimo INTEGER NOT NULL DEFAULT 0
    )
""")
# Dados iniciais se estiver vazio
if cursor.execute("SELECT COUNT(*) FROM produtos").fetchone()[0] == 0:
    cursor.executemany(
        "INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (?, ?, ?)",
        [("Martelo", 8, 3), ("Furadeira", 2, 3), ("Alicate", 15, 5)],
    )
    conexao.commit()   # commit = SALVA de verdade no banco


def ler_inteiro(pergunta):
    """Pergunta até a pessoa digitar um número inteiro."""
    while True:
        texto = input(pergunta).strip()
        if texto.lstrip("-").isdigit():
            return int(texto)
        print("Digite um número válido.")


def bubble_sort(lista):
    """Ordena por nome (A-Z) com Bubble Sort."""
    v = list(lista)
    n = len(v)
    for i in range(n - 1):
        for j in range(n - 1 - i):
            if v[j]["nome"].lower() > v[j + 1]["nome"].lower():
                v[j], v[j + 1] = v[j + 1], v[j]   # troca (jeito Python)
    return v


def listar():
    produtos = cursor.execute("SELECT * FROM produtos").fetchall()
    for p in bubble_sort(produtos):
        alerta = "  <-- ABAIXO DO MÍNIMO!" if p["quantidade"] < p["estoque_minimo"] else ""
        print(f'{p["id"]} | {p["nome"]} | qtd: {p["quantidade"]} | mín: {p["estoque_minimo"]}{alerta}')


def cadastrar():
    nome = input("Nome: ").strip()
    if nome == "":
        print("O nome é obrigatório.")
        return
    qtd = ler_inteiro("Quantidade: ")
    minimo = ler_inteiro("Estoque mínimo: ")
    if qtd < 0 or minimo < 0:
        print("Não pode ser negativo.")
        return
    # Os ? são trocados pelos valores com segurança
    cursor.execute("INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (?, ?, ?)", (nome, qtd, minimo))
    conexao.commit()
    print("Cadastrado!")


def editar():
    id_ = ler_inteiro("ID: ")
    p = cursor.execute("SELECT * FROM produtos WHERE id = ?", (id_,)).fetchone()
    if p is None:
        print("Não encontrado.")
        return
    nome = input(f'Novo nome (Enter mantém "{p["nome"]}"): ').strip() or p["nome"]
    minimo = ler_inteiro("Novo estoque mínimo: ")
    cursor.execute("UPDATE produtos SET nome = ?, estoque_minimo = ? WHERE id = ?", (nome, minimo, id_))
    conexao.commit()
    print("Alterado!")


def excluir():
    id_ = ler_inteiro("ID: ")
    if input("Tem certeza? (s/n): ").lower() == "s":
        cursor.execute("DELETE FROM produtos WHERE id = ?", (id_,))
        conexao.commit()
        print("Excluído!")


def movimentar(entrada):
    id_ = ler_inteiro("ID: ")
    p = cursor.execute("SELECT * FROM produtos WHERE id = ?", (id_,)).fetchone()
    if p is None:
        print("Não encontrado.")
        return
    qtd = ler_inteiro("Quantidade: ")
    if qtd <= 0:
        print("Tem que ser maior que zero.")
        return
    if not entrada and qtd > p["quantidade"]:
        print(f'Estoque insuficiente. Disponível: {p["quantidade"]}')
        return
    nova = p["quantidade"] + qtd if entrada else p["quantidade"] - qtd
    cursor.execute("UPDATE produtos SET quantidade = ? WHERE id = ?", (nova, id_))
    conexao.commit()
    print(f"Registrado! Estoque atual: {nova}")
    if nova < p["estoque_minimo"]:
        print(f'*** ALERTA: {p["nome"]} abaixo do estoque mínimo! ***')


# ---------- PROGRAMA PRINCIPAL ----------
if input("Login: ") != "admin" or input("Senha: ") != "123":
    print("Login ou senha incorretos.")
else:
    while True:
        print("\n1-Listar 2-Cadastrar 3-Editar 4-Excluir 5-Entrada 6-Saída 0-Sair")
        op = input("Escolha: ").strip()
        if op == "1": listar()
        elif op == "2": cadastrar()
        elif op == "3": editar()
        elif op == "4": excluir()
        elif op == "5": movimentar(True)
        elif op == "6": movimentar(False)
        elif op == "0": break
        else: print("Opção inválida.")

conexao.close()
