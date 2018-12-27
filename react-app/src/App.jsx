import React, {Component} from 'react';
import Start from './component/start.jsx';
import Form from './component/form.jsx';
import TopMenu from './component/topMenu.jsx';
import ItemPost from './component/itemPost.jsx';

const API = 'http://localhost/index.php?api';


class App extends Component {

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({hits: data.dataProvider}));
    }
    render() {
        console.log('tam', this.state);
        return (
            <div className="App">
                <header className="App-header">
                    <div>
                        <TopMenu/>
                        <Start/>
                        <ItemPost posts={this.state}/>
                        <Form/>
                    </div>
                </header>
            </div>
        );
    }
}

export default App;

