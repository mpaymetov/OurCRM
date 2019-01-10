import React, {Component} from 'react';
import ItemPost from './itemPost.jsx';
import {Link, BrowserRouter} from 'react-router-dom';

const API = '/api/funnels';

class Funnel extends Component {
    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({hits: data.items}));
    }

    render() {
        if (this.props.posts !== null) {
            return (
                <div>
                    <ItemPost posts={this.state}/>
                </div>
            )

        } else {
            return (<p>do not render</p>);
        }

    }
}
export default Funnel;