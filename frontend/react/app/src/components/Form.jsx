const Form = ({ input, setInput, addTodo, error, setError }) => {
    return (
        <form
            onSubmit={(e) => {
                e.preventDefault();
                if (input.length > 3) {
                    setError(false);
                    addTodo(input);
                    return;
                }
                setError(true);
            }}
        >
            <h1>{input}</h1>
            <input
                className={error ? "input input--error" : "input"}
                value={input}
                onChange={({ target }) => {
                    setInput(target.value);
                    setError(false);
                }}
            />
            <button>add todo</button>
        </form>
    );
};

export default Form;
