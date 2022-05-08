import { useState } from "react";
import logo from "./logo.svg";
import "./App.css";
import useQuery from "./hooks/useQuery";

function App() {
  const { data, error, loading } = useQuery();
  return (
    <div className="App">
      {loading && <div>Loading</div>}
      {data && <div>data</div>}
      {error && <div>{error}</div>}
    </div>
  );
}

export default App;
