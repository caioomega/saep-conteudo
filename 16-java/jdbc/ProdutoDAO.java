// ==============================================================
// PRODUTODAO.JAVA - CRUD em Java conversando com o MySQL (JDBC)
//
// DAO = "Data Access Object": a classe que cuida do banco.
// Usa o banco saep_estoque da pasta 11 (rode o banco.sql antes).
//
// !!! PRECISA DO DRIVER DO MYSQL (um arquivo .jar) !!!
// Leia o EXPLICACAO.txt desta pasta. Sem o .jar, compila mas
// dá erro "No suitable driver" ao rodar.
// ==============================================================
import java.sql.*;   // Connection, PreparedStatement, ResultSet...

public class ProdutoDAO {

    // Endereço do banco: jdbc:mysql://servidor:porta/banco
    private static final String URL = "jdbc:mysql://localhost:3306/saep_estoque";
    private static final String USUARIO = "root";
    private static final String SENHA = "";   // coloque a senha do seu MySQL

    // Abre a conexão
    public static Connection conectar() throws SQLException {
        return DriverManager.getConnection(URL, USUARIO, SENHA);
    }

    // C - INSERIR
    public static void inserir(String nome, int quantidade, int minimo) throws SQLException {
        String sql = "INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (?, ?, ?)";
        // try-with-resources: fecha a conexão sozinho no final
        try (Connection c = conectar(); PreparedStatement ps = c.prepareStatement(sql)) {
            ps.setString(1, nome);       // troca o 1º ? pelo nome
            ps.setInt(2, quantidade);    // 2º ?
            ps.setInt(3, minimo);        // 3º ?
            ps.executeUpdate();          // executeUpdate = INSERT, UPDATE, DELETE
        }
    }

    // R - LISTAR
    public static void listar() throws SQLException {
        String sql = "SELECT id, nome, quantidade, estoque_minimo FROM produtos ORDER BY nome";
        try (Connection c = conectar();
             PreparedStatement ps = c.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {       // executeQuery = SELECT
            while (rs.next()) {                        // cada linha
                System.out.println(rs.getInt("id") + " | " + rs.getString("nome")
                        + " | qtd: " + rs.getInt("quantidade") + " | mín: " + rs.getInt("estoque_minimo"));
            }
        }
    }

    // U - ALTERAR quantidade
    public static void alterarQuantidade(int id, int novaQuantidade) throws SQLException {
        String sql = "UPDATE produtos SET quantidade = ? WHERE id = ?";
        try (Connection c = conectar(); PreparedStatement ps = c.prepareStatement(sql)) {
            ps.setInt(1, novaQuantidade);
            ps.setInt(2, id);
            ps.executeUpdate();
        }
    }

    // D - EXCLUIR
    public static void excluir(int id) throws SQLException {
        try (Connection c = conectar(); PreparedStatement ps = c.prepareStatement("DELETE FROM produtos WHERE id = ?")) {
            ps.setInt(1, id);
            ps.executeUpdate();
        }
    }

    // Teste rápido
    public static void main(String[] args) {
        try {
            inserir("Trena 5m", 10, 2);
            listar();
        } catch (SQLException e) {
            System.out.println("Erro no banco: " + e.getMessage());
        }
    }
}
