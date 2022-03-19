function Person({ name = "unknown", age, hobbies, children, className = "" }) {
    return (
        <div className={"person " + className ?? ""}>
            <h2 className="person__name">Naam: {name}</h2>
            {age && <h3>Leeftijd: {age}</h3>}
            {hobbies && <p>hobbies: {hobbies.join(", ")}</p>}
            <h1>{children}</h1>
        </div>
    );
}

export default Person;
