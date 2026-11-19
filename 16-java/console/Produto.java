// ==============================================================
// PRODUTO.JAVA - a CLASSE Produto (o "molde" de um produto)
// Exemplo de POO: atributos privados + construtor + getters/setters
// ==============================================================
public class Produto {

    // ATRIBUTOS (as características). private = só esta classe mexe direto
    private int id;
    private String nome;
    private int quantidade;
    private int estoqueMinimo;

    // CONSTRUTOR: roda quando você faz  new Produto(...)
    public Produto(int id, String nome, int quantidade, int estoqueMinimo) {
        this.id = id;                 // this.id = o atributo; id = o parâmetro
        this.nome = nome;
        this.quantidade = quantidade;
        this.estoqueMinimo = estoqueMinimo;
    }

    // GETTERS (ler) e SETTERS (alterar) = ENCAPSULAMENTO
    public int getId() { return id; }
    public String getNome() { return nome; }
    public void setNome(String nome) { this.nome = nome; }
    public int getQuantidade() { return quantidade; }
    public void setQuantidade(int quantidade) { this.quantidade = quantidade; }
    public int getEstoqueMinimo() { return estoqueMinimo; }
    public void setEstoqueMinimo(int estoqueMinimo) { this.estoqueMinimo = estoqueMinimo; }

    // MÉTODO com regra de negócio
    public boolean estaAbaixoDoMinimo() {
        return quantidade < estoqueMinimo;
    }

    // toString: como o objeto aparece quando você dá System.out.println(produto)
    @Override
    public String toString() {
        String alerta = estaAbaixoDoMinimo() ? "  <-- ABAIXO DO MÍNIMO!" : "";
        return id + " | " + nome + " | qtd: " + quantidade + " | mín: " + estoqueMinimo + alerta;
    }
}
