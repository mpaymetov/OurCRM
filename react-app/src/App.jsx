import React, { Component } from 'react';
import Start from './component/start.jsx';
import Form from './component/form.jsx';

class App extends Component {
    render() {
        return (
            <div className="App">
                <header className="App-header">
                    <div>
                        <Start/>
                        <Form/>
                    </div>
                </header>
            </div>
        );
    }
}

export default App;

