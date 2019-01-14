import React, {Component} from 'react';
import ItemPost from "./itemPost.jsx";


class FirstColumn extends Component {
    constructor(props) {
        super(props);
        this.state = {column : this.props};

    }

    render() {
        console.log("first state", this.state);
        if (this.state.column.column.info.allModels.length > 0)  {
            return (
                <ItemPost column={this.state.column}/>
            );
        }
        return<p>пока нет событий</p>;
    }
}

export default FirstColumn