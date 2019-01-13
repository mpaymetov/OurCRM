import React, {Component} from 'react';
import ItemPost from './itemPost.jsx';
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
        console.log(this.state.data)
        if (this.props.posts !== null) {
            return (
                <div>
                    <ItemPost posts={this.state.data}/>
                </div>
            )

        } else {
            return (<p>do not render</p>);
        }

    }
}

export default Funnel;