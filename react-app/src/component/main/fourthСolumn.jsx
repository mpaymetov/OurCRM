import React, {Component} from 'react';
import ItemPost from "./itemPost.jsx";


class ForthColumn extends Component {
    constructor(props) {
        super(props);
        this.state = {column : this.props.column};

    }

    render() {
        console.log("forth state", this.state);
        if (this.state.column.info.allModels.length > 0)  {
            return (
                <ItemPost column={this.state.column.info.allModels}/>
            );
        }
        return<p>пока нет событий</p>;
    }
}

export default ForthColumn;