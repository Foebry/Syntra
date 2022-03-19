const TodoList = ({ todos, deleteTodo, checkTodo }) => {
    return (
        <>
            <h1>List of todos</h1>
            <ul>
                {todos.map(({ id, checked, name }) => (
                    <li key={id} className={checked ? "checked" : ""}>
                        {name}
                        <button onClick={() => deleteTodo(id)}>
                            delete
                        </button>{" "}
                        <button onClick={() => checkTodo(id)}>check</button>
                    </li>
                ))}
            </ul>
        </>
    );
};

export default TodoList;
