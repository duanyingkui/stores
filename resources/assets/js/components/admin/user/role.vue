<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>角色管理</el-breadcrumb-item>
                <el-breadcrumb-item>角色列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <router-link to="/role/edit">
            <el-button type="primary" size="small">添加角色</el-button>
        </router-link>
        <el-table
                :data="tableData"
                border
                style="width: 100%; margin-top:10px;">
            <el-table-column
                    label="角色名称">
                <template slot-scope="scope">
                    <span style="margin-left: 10px"></span>
                </template>
            </el-table-column>
            <el-table-column
                    label="角色类型" title="内置角色无法删除和更改">
                <template>
                    <span style="margin-left: 10px"></span>
                </template slot-scope="scope">
            </el-table-column>
            <el-table-column label="操作">
                <template>
                    <el-button
                            size="small"
                            type="primary"
                            >编 辑
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"                           
                            > 删 除 </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                @size-change="onPageSizeChange"
                @current-change="onPageChange"
                :current-page="page"
                :page-sizes="[10, 20, 50, 100]"
                :page-size="pageSize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
        </el-pagination>
    </div>
</template>
