import { Head } from '@inertiajs/react';
import { Car, Heart, Trophy, Users } from 'lucide-react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { User } from '@/types';

type Stats = {
    total_users: number;
    total_cars: number;
    total_likes: number;
    top_brand: string | null;
    top_model: string | null;
    top_type: string | null;
};

type RecentUser = User & { car_likes_count: number };

export default function AdminDashboard({
    stats,
    recent_users,
}: {
    stats: Stats;
    recent_users: RecentUser[];
}) {
    return (
        <>
            <Head title="Admin Dashboard" />

            <div className="flex flex-col gap-6 p-6">
                <div>
                    <h1 className="text-2xl font-bold tracking-tight">Admin Dashboard</h1>
                    <p className="text-muted-foreground">Overview of users, cars, and activity.</p>
                </div>

                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <StatCard icon={Users} label="Total Users" value={stats.total_users} />
                    <StatCard icon={Car} label="Cars in Inventory" value={stats.total_cars} />
                    <StatCard icon={Heart} label="Total Likes" value={stats.total_likes} />
                </div>

                <div className="grid gap-4 sm:grid-cols-3">
                    <PreferenceCard label="Most Liked Brand" value={stats.top_brand} />
                    <PreferenceCard label="Most Liked Model" value={stats.top_model} />
                    <PreferenceCard label="Most Liked Type" value={stats.top_type} />
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Recent Registrations</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead className="text-right">Likes</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {recent_users.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={3} className="text-center text-muted-foreground">
                                            No users yet.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    recent_users.map((user) => (
                                        <TableRow key={user.id}>
                                            <TableCell className="font-medium">{user.name}</TableCell>
                                            <TableCell className="text-muted-foreground">{user.email}</TableCell>
                                            <TableCell className="text-right">{user.car_likes_count}</TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

function StatCard({ icon: Icon, label, value }: { icon: React.ElementType; label: string; value: number }) {
    return (
        <Card>
            <CardHeader className="flex flex-row items-center justify-between pb-2">
                <CardTitle className="text-sm font-medium text-muted-foreground">{label}</CardTitle>
                <Icon className="size-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div className="text-3xl font-bold">{value.toLocaleString()}</div>
            </CardContent>
        </Card>
    );
}

function PreferenceCard({ label, value }: { label: string; value: string | null }) {
    return (
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                    <Trophy className="size-4" />
                    {label}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <p className="text-xl font-semibold">{value ?? <span className="text-muted-foreground text-base">No data yet</span>}</p>
            </CardContent>
        </Card>
    );
}
