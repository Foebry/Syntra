import { useState } from "react";
import TodoList from "./components/TodoList";
import Form from "./components/Form";
import { nanoid } from "nanoid";
import "./style.scss";

const App = () => {
    const [input, setInput] = useState("");
    const [error, setError] = useState(false);
    const [todos, setTodos] = useState([]);
    const addTodo = (name) => {
        setTodos([...todos, { id: nanoid(5), name, checked: false }]);
        setInput("");
    };
    const deleteTodo = (id) => setTodos(todos.filter((todo) => todo.id != id));
    const checkTodo = (id) =>
        setTodos(
            todos.map((todo) => {
                if (todo.id == id) {
                    todo.checked = !todo.checked;
                }
                return todo;
            })
        );
    return (
        <div className="todoApp">
            <Form
                input={input}
                setInput={setInput}
                addTodo={addTodo}
                error={error}
                setError={setError}
            />
            <TodoList
                todos={todos}
                addTodo={addTodo}
                deleteTodo={deleteTodo}
                checkTodo={checkTodo}
            />
        </div>
    );
};

export default App;
