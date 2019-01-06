import React, {Component} from 'react';
import Start from './component/start.jsx';
import Form from './component/form.jsx';
import TopMenu from './component/topMenu.jsx';
import Funnel from './component/main/funnelWrap.jsx';


class App extends Component {


    render() {
        return (
            <div className="App">
                <header className="App-header">
                    <div>
                        <TopMenu/>
                        <Start/>
                        <Funnel/>
                        <Form/>
                    </div>
                </header>
            </div>
        );
    }
}

export default App;

