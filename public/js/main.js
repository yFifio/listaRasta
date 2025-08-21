document.addEventListener("DOMContentLoaded", () => {
  const tasksContainer = document.getElementById("tasks");

  // Se o container principal de tarefas não existir, o script não continua.
  if (!tasksContainer) {
    return;
  }

  tasksContainer.addEventListener("click", (event) => {
    // Verifica se o clique foi no botão de editar (ou em seu ícone)
    const editButton = event.target.closest(".edit-btn");
    if (editButton) {
      const task = editButton.closest(".task");
      if (task) {
        const taskView = task.querySelector(".task-view");
        const editForm = task.querySelector(".edit-task");

        // Esconde a visualização da tarefa e mostra o formulário de edição
        taskView.classList.add("hidden");
        editForm.classList.remove("hidden");
      }
    }

    // Verifica se o clique foi no botão de cancelar (ou em seu ícone)
    const cancelButton = event.target.closest(".cancel-button");
    if (cancelButton) {
      const task = cancelButton.closest(".task");
      if (task) {
        const taskView = task.querySelector(".task-view");
        const editForm = task.querySelector(".edit-task");

        // Esconde o formulário de edição e mostra a visualização da tarefa
        editForm.classList.add("hidden");
        taskView.classList.remove("hidden");
      }
    }
  });
});
