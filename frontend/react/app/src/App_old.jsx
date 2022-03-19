import Person from "./components/Person";
import Counter from "./components/Counter";
import Name from "./components/Name";
import "./style.scss";

function App() {
    return (
        <>
            <h1>React is amazing</h1>
            <Name />
            <Counter />
            <Person
                name="Sander"
                age={30}
                hobbies={["ain't nobody got time for that"]}
            >
                😂
            </Person>
            <hr />
            <Person
                name="Jos"
                age={22}
                hobbies={[
                    "zwemmen",
                    "springen",
                    "vliegen",
                    "vallen en weer doorgaan",
                ]}
            >
                😊
            </Person>
            <hr />
            <Person name="Ilse" age={49} hobbies={["vogelepik"]}>
                🤣
            </Person>
            <hr />
            <Person>👌</Person>
        </>
    );
}

export default App;
