import React, {Component} from 'react';
import StatusRow from './statusRow.jsx';
import {Link, BrowserRouter} from 'react-router-dom';

const API = '/api/funnels';

class Funnel extends Component {
    constructor(props) {
        super(props);
        this.state = {data: ''};
    }

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({data: data}))
            .catch((error) => {
                console.error(error);
            });
    }

    render() {
        console.log("wrap", this.state.data)
        if (this.state.data !== '') {
            return (
                <div>
                    <StatusRow data={this.state.data}/>
                </div>
            )
        } else {
            return (<p>do not render</p>);
        }
    }
}

export default Funnel;