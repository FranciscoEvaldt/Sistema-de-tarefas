$(function () {
  const carregar = function () {
    const status = $("#filtro-status").val() || "";
    $.post(
      "tarefas.php",
      { acao: "listar", status: status },
      function (resp) {
        let html = "";
        if (!resp || resp.length === 0) {
          html = '<div class="alert alert-secondary">Nenhuma tarefa.</div>';
          $("#lista-tarefas").html(html);
          return;
        }
        html = '<ul class="list-group">';
        resp.forEach((t) => {
          const badge =
            t.status === "concluida"
              ? '<span class="badge bg-success me-2">Concluída</span>'
              : '<span class="badge bg-warning text-dark me-2">Pendente</span>';
          html += `<li class="list-group-item d-flex justify-content-between align-items-start bg-body-secondary text-light">
                    <div>
                      ${badge}<strong>${escapeHtml(
            t.titulo
          )}</strong><div class="text-muted small">${escapeHtml(
            t.descricao || ""
          )}</div>
                    </div>
                    <div>
                      ${
                        t.status === "pendente"
                          ? `<button class="btn btn-sm btn-success me-1 concluir" data-id="${t.id}">Concluir</button>`
                          : ""
                      }
                      <button class="btn btn-sm btn-primary me-1 editar" data-id="${
                        t.id
                      }">Editar</button>
                      <button class="btn btn-sm btn-danger excluir" data-id="${
                        t.id
                      }">Excluir</button>
                    </div>
                </li>`;
        });
        html += "</ul>";
        $("#lista-tarefas").html(html);
      },
      "json"
    );
  };

  function escapeHtml(text) {
    if (!text) return "";
    return String(text).replace(/[&<>\"'`=\/]/g, function (s) {
      return {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "/": "&#x2F;",
        "`": "&#x60;",
        "=": "&#x3D;",
      }[s];
    });
  }

  carregar();

  $("#form-tarefa").on("submit", function (e) {
    e.preventDefault();
    const data = {
      acao: "adicionar",
      titulo: $("#titulo").val(),
      descricao: $("#descricao").val(),
    };
    $.post(
      "tarefas.php",
      data,
      function (resp) {
        if (resp.success) {
          $("#form-tarefa")[0].reset();
          carregar();
        } else alert(resp.msg || "Erro ao adicionar");
      },
      "json"
    );
  });

  $("#lista-tarefas").on("click", ".concluir", function () {
    const id = $(this).data("id");
    $.post(
      "tarefas.php",
      { acao: "concluir", id: id },
      function () {
        carregar();
      },
      "json"
    );
  });

  $("#lista-tarefas").on("click", ".excluir", function () {
    if (!confirm("Confirma exclusão?")) return;
    const id = $(this).data("id");
    $.post(
      "tarefas.php",
      { acao: "excluir", id: id },
      function () {
        carregar();
      },
      "json"
    );
  });

  $("#lista-tarefas").on("click", ".editar", function () {
    const id = $(this).data("id");
    $.get(
      "tarefas.php",
      { acao: "get", id: id },
      function (t) {
        if (!t || !t.id) {
          alert("Tarefa não encontrada");
          return;
        }
        $("#editar-id").val(t.id);
        $("#editar-titulo").val(t.titulo);
        $("#editar-descricao").val(t.descricao);
        $("#editar-status").val(t.status);
        const modal = new bootstrap.Modal(
          document.getElementById("modalEditar")
        );
        modal.show();
      },
      "json"
    );
  });

  $("#form-editar").on("submit", function (e) {
    e.preventDefault();
    const data = $(this).serialize() + "&acao=editar";
    $.post(
      "tarefas.php",
      data,
      function (resp) {
        if (resp.success) {
          const modalEl = document.getElementById("modalEditar");
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();
          carregar();
        } else {
          alert(resp.msg || "Erro ao editar");
        }
      },
      "json"
    );
  });

  $("#filtro-status").on("change", function () {
    carregar();
  });
});
