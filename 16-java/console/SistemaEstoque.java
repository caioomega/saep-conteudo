// ==============================================================
// SISTEMAESTOQUE.JAVA - CRUD no terminal (console) com menu
// Os dados ficam numa lista (ArrayList) enquanto o programa roda.
// Rodar: dois cliques no rodar.bat desta pasta.
// ==============================================================
import java.util.ArrayList;   // lista que cresce sozinha
import java.util.Scanner;     // lê o que a pessoa digita

public class SistemaEstoque {

    // static = pertence à classe (dá pra usar no main direto)
    static ArrayList<Produto> produtos = new ArrayList<>();
    static Scanner teclado = new Scanner(System.in);
    static int proximoId = 1;

    // O programa COMEÇA aqui
    public static void main(String[] args) {
        // 3 produtos iniciais
        produtos.add(new Produto(proximoId++, "Martelo", 8, 3));
        produtos.add(new Produto(proximoId++, "Furadeira", 2, 3));
        produtos.add(new Produto(proximoId++, "Alicate", 15, 5));

        if (!login()) {
            System.out.println("Login ou senha incorretos. Saindo.");
            return;
        }

        int opcao;
        do {
            System.out.println("\n===== MENU =====");
            System.out.println("1 - Listar produtos (ordem alfabética)");
            System.out.println("2 - Cadastrar produto");
            System.out.println("3 - Editar produto");
            System.out.println("4 - Excluir produto");
            System.out.println("5 - Entrada de estoque");
            System.out.println("6 - Saída de estoque");
            System.out.println("7 - Buscar por nome");
            System.out.println("0 - Sair");
            opcao = lerInteiro("Escolha: ");

            // switch: escolhe o que fazer pela opção
            switch (opcao) {
                case 1: listar(); break;
                case 2: cadastrar(); break;
                case 3: editar(); break;
                case 4: excluir(); break;
                case 5: movimentar(true); break;
                case 6: movimentar(false); break;
                case 7: buscar(); break;
                case 0: System.out.println("Até mais!"); break;
                default: System.out.println("Opção inválida.");
            }
        } while (opcao != 0);   // repete até escolher 0
    }

    // ---------- LOGIN ----------
    static boolean login() {
        System.out.print("Login: ");
        String login = teclado.nextLine();
        System.out.print("Senha: ");
        String senha = teclado.nextLine();
        // Texto em Java compara com .equals (NUNCA com ==)
        if (login.equals("admin") && senha.equals("123")) {
            System.out.println("Bem-vindo, Administrador!");
            return true;
        }
        return false;
    }

    // ---------- LER NÚMERO SEM DAR ERRO SE DIGITAR LETRA ----------
    static int lerInteiro(String pergunta) {
        while (true) {
            System.out.print(pergunta);
            String texto = teclado.nextLine().trim();
            try {
                return Integer.parseInt(texto);   // transforma texto em int
            } catch (NumberFormatException e) {
                System.out.println("Digite um número válido.");
            }
        }
    }

    // ---------- BUBBLE SORT por nome ----------
    static ArrayList<Produto> ordenarPorNome() {
        ArrayList<Produto> lista = new ArrayList<>(produtos);   // cópia
        int n = lista.size();
        for (int i = 0; i < n - 1; i++) {
            for (int j = 0; j < n - 1 - i; j++) {
                if (lista.get(j).getNome().compareToIgnoreCase(lista.get(j + 1).getNome()) > 0) {
                    Produto temp = lista.get(j);
                    lista.set(j, lista.get(j + 1));
                    lista.set(j + 1, temp);
                }
            }
        }
        return lista;
    }

    static Produto buscarPorId(int id) {
        for (Produto p : produtos) {          // "for each": cada p da lista
            if (p.getId() == id) return p;
        }
        return null;                          // null = não achou
    }

    // ---------- R: LISTAR ----------
    static void listar() {
        if (produtos.isEmpty()) {
            System.out.println("Nenhum produto.");
            return;
        }
        for (Produto p : ordenarPorNome()) {
            System.out.println(p);            // usa o toString()
        }
    }

    static void buscar() {
        System.out.print("Parte do nome: ");
        String termo = teclado.nextLine().toLowerCase();
        for (Produto p : ordenarPorNome()) {
            if (p.getNome().toLowerCase().contains(termo)) System.out.println(p);
        }
    }

    // ---------- C: CADASTRAR ----------
    static void cadastrar() {
        System.out.print("Nome: ");
        String nome = teclado.nextLine().trim();
        if (nome.isEmpty()) {
            System.out.println("O nome é obrigatório.");
            return;
        }
        int qtd = lerInteiro("Quantidade: ");
        int minimo = lerInteiro("Estoque mínimo: ");
        if (qtd < 0 || minimo < 0) {
            System.out.println("Não pode ser negativo.");
            return;
        }
        produtos.add(new Produto(proximoId++, nome, qtd, minimo));
        System.out.println("Produto cadastrado!");
    }

    // ---------- U: EDITAR ----------
    static void editar() {
        Produto p = buscarPorId(lerInteiro("ID do produto: "));
        if (p == null) {
            System.out.println("Produto não encontrado.");
            return;
        }
        System.out.print("Novo nome (Enter mantém \"" + p.getNome() + "\"): ");
        String nome = teclado.nextLine().trim();
        if (!nome.isEmpty()) p.setNome(nome);
        int minimo = lerInteiro("Novo estoque mínimo: ");
        if (minimo >= 0) p.setEstoqueMinimo(minimo);
        System.out.println("Produto alterado!");
    }

    // ---------- D: EXCLUIR ----------
    static void excluir() {
        Produto p = buscarPorId(lerInteiro("ID do produto: "));
        if (p == null) {
            System.out.println("Produto não encontrado.");
            return;
        }
        System.out.print("Tem certeza? (s/n): ");
        if (teclado.nextLine().equalsIgnoreCase("s")) {
            produtos.remove(p);
            System.out.println("Excluído!");
        }
    }

    // ---------- ENTRADA / SAÍDA + ALERTA ----------
    static void movimentar(boolean entrada) {
        Produto p = buscarPorId(lerInteiro("ID do produto: "));
        if (p == null) {
            System.out.println("Produto não encontrado.");
            return;
        }
        int qtd = lerInteiro("Quantidade: ");
        if (qtd <= 0) {
            System.out.println("Quantidade tem que ser maior que zero.");
            return;
        }
        if (!entrada && qtd > p.getQuantidade()) {
            System.out.println("Estoque insuficiente. Disponível: " + p.getQuantidade());
            return;
        }
        p.setQuantidade(entrada ? p.getQuantidade() + qtd : p.getQuantidade() - qtd);
        System.out.println("Registrado! Estoque atual: " + p.getQuantidade());
        if (p.estaAbaixoDoMinimo()) {
            System.out.println("*** ALERTA: " + p.getNome() + " está abaixo do estoque mínimo! ***");
        }
    }
}
