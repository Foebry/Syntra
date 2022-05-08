import useMousePosition from "../hooks/useMousePosition";

const Mouse = () => {
    const [x, y] = useMousePosition();
    return (
        <div>
            <h1>x: {x}</h1>
            <h1>y: {y}</h1>
        </div>
    );
};

export default Mouse;
