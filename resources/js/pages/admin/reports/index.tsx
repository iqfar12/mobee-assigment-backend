import { Head, Link } from '@inertiajs/react';
import { show } from '@/routes/admin/users';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

type ReportRow = {
    user: { id: number; name: string; email: string; created_at: string };
    car_likes_count: number;
    most_liked_brand: string | null;
    most_liked_model: string | null;
    most_liked_type: string | null;
};

export default function AdminReportsIndex({ report }: { report: ReportRow[] }) {
    return (
        <>
            <Head title="Reports" />

            <div className="flex flex-col gap-6 p-6">
                <div>
                    <h1 className="text-2xl font-bold tracking-tight">User Preference Reports</h1>
                    <p className="text-muted-foreground">Most liked brand, model, and type per user.</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Reports ({report.length} users)</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>User</TableHead>
                                    <TableHead className="text-right">Likes</TableHead>
                                    <TableHead>Top Brand</TableHead>
                                    <TableHead>Top Model</TableHead>
                                    <TableHead>Top Type</TableHead>
                                    <TableHead />
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {report.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center text-muted-foreground">
                                            No data yet.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    report.map((row) => (
                                        <TableRow key={row.user.id}>
                                            <TableCell>
                                                <div className="font-medium">{row.user.name}</div>
                                                <div className="text-xs text-muted-foreground">{row.user.email}</div>
                                            </TableCell>
                                            <TableCell className="text-right">{row.car_likes_count}</TableCell>
                                            <TableCell>
                                                {row.most_liked_brand ? (
                                                    <Badge variant="secondary">{row.most_liked_brand}</Badge>
                                                ) : (
                                                    <span className="text-muted-foreground text-xs">—</span>
                                                )}
                                            </TableCell>
                                            <TableCell>
                                                {row.most_liked_model ? (
                                                    <Badge variant="outline">{row.most_liked_model}</Badge>
                                                ) : (
                                                    <span className="text-muted-foreground text-xs">—</span>
                                                )}
                                            </TableCell>
                                            <TableCell>
                                                {row.most_liked_type ? (
                                                    <Badge>{row.most_liked_type}</Badge>
                                                ) : (
                                                    <span className="text-muted-foreground text-xs">—</span>
                                                )}
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <Button variant="ghost" size="sm" asChild>
                                                    <Link href={show({ user: row.user.id })}>View User</Link>
                                                </Button>
                                            </TableCell>
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
